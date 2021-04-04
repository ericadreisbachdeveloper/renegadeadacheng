(function () {
	'use strict';

	var factory = function () {
		// Pass in the windoe Date function also for SSR because the Date class can be lost
		/*jshint eqnull:true */

		var lazysizes, lazySizesCfg;

		(function () {
			var prop;

			var lazySizesDefaults = {
				lazyClass: 'lazyload',
				loadedClass: 'lazyloaded',
				loadingClass: 'lazyloading',
				preloadClass: 'lazypreload',
				errorClass: 'lazyerror',
				//strictClass: 'lazystrict',
				autosizesClass: 'lazyautosizes',
				srcAttr: 'data-src',
				srcsetAttr: 'data-srcset',
				sizesAttr: 'data-sizes',
				//preloadAfterLoad: false,
				minSize: 40,
				customMedia: {},
				init: true,
				expFactor: 1.5,
				hFac: 0.8,
				loadMode: 2,
				loadHidden: true,
				ricTimeout: 0,
				throttleDelay: 125,
			};

			lazySizesCfg = window.lazySizesConfig || window.lazysizesConfig || {};

			for (prop in lazySizesDefaults) {
				if (!(prop in lazySizesCfg)) {
					lazySizesCfg[prop] = lazySizesDefaults[prop];
				}
			}
		})();

		if (!document || !document.getElementsByClassName) {
			return {
				init: function () {},
				cfg: lazySizesCfg,
				noSupport: true,
			};
		}

		var docElem = document.documentElement;

		/**
		 * Update to bind to window because 'this' becomes null during SSR
		 * builds.
		 */
		var addEventListener = window.addEventListener.bind(window);

		var requestIdleCallback = window.requestIdleCallback;

		var regPicture = /^picture$/i;

		var loadEvents = ['load', 'error', 'lazyincluded', '_lazyloaded'];

		var forEach = Array.prototype.forEach;

		var addRemoveLoadEvents = function (dom, fn, add) {
			var action = add ? 'addEventListener' : 'removeEventListener';
			if (add) {
				addRemoveLoadEvents(dom, fn);
			}
			loadEvents.forEach(function (evt) {
				dom[action](evt, fn);
			});
		};

		var triggerEvent = function (elem, name, detail, noBubbles, noCancelable) {
			var event = document.createEvent('Event');

			if (!detail) {
				detail = {};
			}

			detail.instance = lazysizes;

			event.initEvent(name, !noBubbles, !noCancelable);

			event.detail = detail;

			elem.dispatchEvent(event);
			return event;
		};

		var updatePolyfill = function (el, full) {
			var polyfill;
			if (
				!window.HTMLPictureElement &&
				(polyfill = window.picturefill || lazySizesCfg.pf)
			) {
				if (full && full.src && !el.getAttribute('srcset')) {
					el.setAttribute('srcset', full.src);
				}
				polyfill({ reevaluate: true, elements: [el] });
			} else if (full && full.src) {
				el.src = full.src;
			}
		};

		var getCSS = function (elem, style) {
			return (getComputedStyle(elem, null) || {})[style];
		};

		var getWidth = function (elem, parent, width) {
			width = width || elem.offsetWidth;

			while (width < lazySizesCfg.minSize && parent && !elem._lazysizesWidth) {
				width = parent.offsetWidth;
				parent = parent.parentNode;
			}

			return width;
		};

		var rAF = (function () {
			var running, waiting;
			var firstFns = [];
			var secondFns = [];
			var fns = firstFns;

			var run = function () {
				var runFns = fns;

				fns = firstFns.length ? secondFns : firstFns;

				running = true;
				waiting = false;

				while (runFns.length) {
					runFns.shift()();
				}

				running = false;
			};

			var rafBatch = function (fn, queue) {
				if (running && !queue) {
					fn.apply(this, arguments);
				} else {
					fns.push(fn);

					if (!waiting) {
						waiting = true;
						(document.hidden ? setTimeout : requestAnimationFrame)(run);
					}
				}
			};

			rafBatch._lsFlush = run;

			return rafBatch;
		})();

		var rAFIt = function (fn, simple) {
			return simple
				? function () {
						rAF(fn);
				  }
				: function () {
						var that = this;
						var args = arguments;
						rAF(function () {
							fn.apply(that, args);
						});
				  };
		};

		var throttle = function (fn) {
			var running;
			var lastTime = 0;
			var gDelay = lazySizesCfg.throttleDelay;
			var rICTimeout = lazySizesCfg.ricTimeout;
			var run = function () {
				running = false;
				lastTime = Date.now();
				fn();
			};
			var idleCallback =
				requestIdleCallback && rICTimeout > 49
					? function () {
							requestIdleCallback(run, { timeout: rICTimeout });

							if (rICTimeout !== lazySizesCfg.ricTimeout) {
								rICTimeout = lazySizesCfg.ricTimeout;
							}
					  }
					: rAFIt(function () {
							setTimeout(run);
					  }, true);
			return function (isPriority) {
				var delay;

				if ((isPriority = isPriority === true)) {
					rICTimeout = 33;
				}

				if (running) {
					return;
				}

				running = true;

				delay = gDelay - (Date.now() - lastTime);

				if (delay < 0) {
					delay = 0;
				}

				if (isPriority || delay < 9) {
					idleCallback();
				} else {
					setTimeout(idleCallback, delay);
				}
			};
		};

		//based on http://modernjavascript.blogspot.de/2013/08/building-better-debounce.html
		var debounce = function (func) {
			var timeout, timestamp;
			var wait = 99;
			var run = function () {
				timeout = null;
				func();
			};
			var later = function () {
				var last = Date.now() - timestamp;

				if (last < wait) {
					setTimeout(later, wait - last);
				} else {
					(requestIdleCallback || run)(run);
				}
			};

			return function () {
				timestamp = Date.now();

				if (!timeout) {
					timeout = setTimeout(later, wait);
				}
			};
		};

		var loader = (function () {
			var preloadElems, isCompleted, resetPreloadingTimer, loadMode, started;

			var eLvW, elvH, eLtop, eLleft, eLright, eLbottom, isBodyHidden;

			var regImg = /^img$/i;
			var regIframe = /^iframe$/i;

			var supportScroll =
				'onscroll' in window && !/(gle|ing)bot/.test(navigator.userAgent);

			var shrinkExpand = 0;
			var currentExpand = 0;

			var isLoading = 0;
			var lowRuns = -1;

			var resetPreloading = function (e) {
				isLoading--;
				if (!e || isLoading < 0 || !e.target) {
					isLoading = 0;
				}
			};

			var isVisible = function (elem) {
				if (isBodyHidden == null) {
					isBodyHidden = getCSS(document.body, 'visibility') == 'hidden';
				}

				return (
					isBodyHidden ||
					!(
						getCSS(elem.parentNode, 'visibility') == 'hidden' &&
						getCSS(elem, 'visibility') == 'hidden'
					)
				);
			};

			var isNestedVisible = function (elem, elemExpand) {
				var outerRect;
				var parent = elem;
				var visible = isVisible(elem);

				eLtop -= elemExpand;
				eLbottom += elemExpand;
				eLleft -= elemExpand;
				eLright += elemExpand;

				while (
					visible &&
					(parent = parent.offsetParent) &&
					parent != document.body &&
					parent != docElem
				) {
					visible = (getCSS(parent, 'opacity') || 1) > 0;

					if (visible && getCSS(parent, 'overflow') != 'visible') {
						outerRect = parent.getBoundingClientRect();
						visible =
							eLright > outerRect.left &&
							eLleft < outerRect.right &&
							eLbottom > outerRect.top - 1 &&
							eLtop < outerRect.bottom + 1;
					}
				}

				return visible;
			};

			var checkElements = function () {
				var eLlen,
					i,
					rect,
					autoLoadElem,
					loadedSomething,
					elemExpand,
					elemNegativeExpand,
					elemExpandVal,
					beforeExpandVal,
					defaultExpand,
					preloadExpand,
					hFac;
				var lazyloadElems = lazysizes.elements;

				if (
					(loadMode = lazySizesCfg.loadMode) &&
					isLoading < 8 &&
					(eLlen = lazyloadElems.length)
				) {
					i = 0;

					lowRuns++;

					for (; i < eLlen; i++) {
						if (!lazyloadElems[i] || lazyloadElems[i]._lazyRace) {
							continue;
						}

						if (
							!supportScroll ||
							(lazysizes.prematureUnveil &&
								lazysizes.prematureUnveil(lazyloadElems[i]))
						) {
							unveilElement(lazyloadElems[i]);
							continue;
						}

						if (
							!(elemExpandVal = lazyloadElems[i].getAttribute('data-expand')) ||
							!(elemExpand = elemExpandVal * 1)
						) {
							elemExpand = currentExpand;
						}

						if (!defaultExpand) {
							defaultExpand =
								!lazySizesCfg.expand || lazySizesCfg.expand < 1
									? docElem.clientHeight > 500 && docElem.clientWidth > 500
										? 500
										: 370
									: lazySizesCfg.expand;

							lazysizes._defEx = defaultExpand;

							preloadExpand = defaultExpand * lazySizesCfg.expFactor;
							hFac = lazySizesCfg.hFac;
							isBodyHidden = null;

							if (
								currentExpand < preloadExpand &&
								isLoading < 1 &&
								lowRuns > 2 &&
								loadMode > 2 &&
								!document.hidden
							) {
								currentExpand = preloadExpand;
								lowRuns = 0;
							} else if (loadMode > 1 && lowRuns > 1 && isLoading < 6) {
								currentExpand = defaultExpand;
							} else {
								currentExpand = shrinkExpand;
							}
						}

						if (beforeExpandVal !== elemExpand) {
							eLvW = innerWidth + elemExpand * hFac;
							elvH = innerHeight + elemExpand;
							elemNegativeExpand = elemExpand * -1;
							beforeExpandVal = elemExpand;
						}

						rect = lazyloadElems[i].getBoundingClientRect();

						if (
							(eLbottom = rect.bottom) >= elemNegativeExpand &&
							(eLtop = rect.top) <= elvH &&
							(eLright = rect.right) >= elemNegativeExpand * hFac &&
							(eLleft = rect.left) <= eLvW &&
							(eLbottom || eLright || eLleft || eLtop) &&
							(lazySizesCfg.loadHidden || isVisible(lazyloadElems[i])) &&
							((isCompleted &&
								isLoading < 3 &&
								!elemExpandVal &&
								(loadMode < 3 || lowRuns < 4)) ||
								isNestedVisible(lazyloadElems[i], elemExpand))
						) {
							unveilElement(lazyloadElems[i]);
							loadedSomething = true;
							if (isLoading > 9) {
								break;
							}
						} else if (
							!loadedSomething &&
							isCompleted &&
							!autoLoadElem &&
							isLoading < 4 &&
							lowRuns < 4 &&
							loadMode > 2 &&
							(preloadElems[0] || lazySizesCfg.preloadAfterLoad) &&
							(preloadElems[0] ||
								(!elemExpandVal &&
									(eLbottom ||
										eLright ||
										eLleft ||
										eLtop ||
										lazyloadElems[i].getAttribute(lazySizesCfg.sizesAttr) !=
											'auto')))
						) {
							autoLoadElem = preloadElems[0] || lazyloadElems[i];
						}
					}

					if (autoLoadElem && !loadedSomething) {
						unveilElement(autoLoadElem);
					}
				}
			};

			var throttledCheckElements = throttle(checkElements);

			var switchLoadingClass = function (e) {
				var elem = e.target;

				if (elem._lazyCache) {
					delete elem._lazyCache;
					return;
				}

				resetPreloading(e);
				elem.classList.add(lazySizesCfg.loadedClass);
				elem.classList.remove(lazySizesCfg.loadingClass);
				addRemoveLoadEvents(elem, rafSwitchLoadingClass);
				triggerEvent(elem, 'lazyloaded');
			};
			var rafedSwitchLoadingClass = rAFIt(switchLoadingClass);
			var rafSwitchLoadingClass = function (e) {
				rafedSwitchLoadingClass({ target: e.target });
			};

			var changeIframeSrc = function (elem, src) {
				try {
					elem.contentWindow.location.replace(src);
				} catch (e) {
					elem.src = src;
				}
			};

			var handleSources = function (source) {
				var customMedia;

				var sourceSrcset = source.getAttribute(lazySizesCfg.srcsetAttr);

				if (
					(customMedia =
						lazySizesCfg.customMedia[
							source.getAttribute('data-media') || source.getAttribute('media')
						])
				) {
					source.setAttribute('media', customMedia);
				}

				if (sourceSrcset) {
					source.setAttribute('srcset', sourceSrcset);
				}
			};

			var lazyUnveil = rAFIt(function (elem, detail, isAuto, sizes, isImg) {
				var src, srcset, parent, isPicture, event, firesLoad;

				if (
					!(event = triggerEvent(elem, 'lazybeforeunveil', detail))
						.defaultPrevented
				) {
					if (sizes) {
						if (isAuto) {
							elem.classList.add(lazySizesCfg.autosizesClass);
						} else {
							elem.setAttribute('sizes', sizes);
						}
					}

					srcset = elem.getAttribute(lazySizesCfg.srcsetAttr);
					src = elem.getAttribute(lazySizesCfg.srcAttr);

					if (isImg) {
						parent = elem.parentNode;
						isPicture = parent && regPicture.test(parent.nodeName || '');
					}

					firesLoad =
						detail.firesLoad || ('src' in elem && (srcset || src || isPicture));

					event = { target: elem };

					elem.classList.add(lazySizesCfg.loadingClass);

					if (firesLoad) {
						clearTimeout(resetPreloadingTimer);
						resetPreloadingTimer = setTimeout(resetPreloading, 2500);
						addRemoveLoadEvents(elem, rafSwitchLoadingClass, true);
					}

					if (isPicture) {
						forEach.call(parent.getElementsByTagName('source'), handleSources);
					}

					if (srcset) {
						elem.setAttribute('srcset', srcset);
					} else if (src && !isPicture) {
						if (regIframe.test(elem.nodeName)) {
							changeIframeSrc(elem, src);
						} else {
							elem.src = src;
						}
					}

					if (isImg && (srcset || isPicture)) {
						updatePolyfill(elem, { src: src });
					}
				}

				if (elem._lazyRace) {
					delete elem._lazyRace;
				}
				elem.classList.remove(lazySizesCfg.lazyClass);

				rAF(function () {
					// Part of this can be removed as soon as this fix is older: https://bugs.chromium.org/p/chromium/issues/detail?id=7731 (2015)
					var isLoaded = elem.complete && elem.naturalWidth > 1;

					if (!firesLoad || isLoaded) {
						if (isLoaded) {
							elem.classList.add('ls-is-cached');
						}
						switchLoadingClass(event);
						elem._lazyCache = true;
						setTimeout(function () {
							if ('_lazyCache' in elem) {
								delete elem._lazyCache;
							}
						}, 9);
					}
					if (elem.loading == 'lazy') {
						isLoading--;
					}
				}, true);
			});

			var unveilElement = function (elem) {
				if (elem._lazyRace) {
					return;
				}
				var detail;

				var isImg = regImg.test(elem.nodeName);

				//allow using sizes="auto", but don't use. it's invalid. Use data-sizes="auto" or a valid value for sizes instead (i.e.: sizes="80vw")
				var sizes =
					isImg &&
					(elem.getAttribute(lazySizesCfg.sizesAttr) ||
						elem.getAttribute('sizes'));
				var isAuto = sizes == 'auto';

				if (
					(isAuto || !isCompleted) &&
					isImg &&
					(elem.getAttribute('src') || elem.srcset) &&
					!elem.complete &&
					!elem.classList.contains(lazySizesCfg.errorClass) &&
					elem.classList.contains(lazySizesCfg.lazyClass)
				) {
					return;
				}

				detail = triggerEvent(elem, 'lazyunveilread').detail;

				if (isAuto) {
					autoSizer.updateElem(elem, true, elem.offsetWidth);
				}

				elem._lazyRace = true;
				isLoading++;

				lazyUnveil(elem, detail, isAuto, sizes, isImg);
			};

			var afterScroll = debounce(function () {
				lazySizesCfg.loadMode = 3;
				throttledCheckElements();
			});

			var altLoadmodeScrollListner = function () {
				if (lazySizesCfg.loadMode == 3) {
					lazySizesCfg.loadMode = 2;
				}
				afterScroll();
			};

			var onload = function () {
				if (isCompleted) {
					return;
				}
				if (Date.now() - started < 999) {
					setTimeout(onload, 999);
					return;
				}

				isCompleted = true;

				lazySizesCfg.loadMode = 3;

				throttledCheckElements();

				addEventListener('scroll', altLoadmodeScrollListner, true);
			};

			return {
				_: function () {
					started = Date.now();

					lazysizes.elements = document.getElementsByClassName(
						lazySizesCfg.lazyClass
					);
					preloadElems = document.getElementsByClassName(
						lazySizesCfg.lazyClass + ' ' + lazySizesCfg.preloadClass
					);

					addEventListener('scroll', throttledCheckElements, true);

					addEventListener('resize', throttledCheckElements, true);

					addEventListener('pageshow', function (e) {
						if (e.persisted) {
							var loadingElements = document.querySelectorAll(
								'.' + lazySizesCfg.loadingClass
							);

							if (loadingElements.length && loadingElements.forEach) {
								requestAnimationFrame(function () {
									loadingElements.forEach(function (img) {
										if (img.complete) {
											unveilElement(img);
										}
									});
								});
							}
						}
					});

					if (window.MutationObserver) {
						new MutationObserver(throttledCheckElements).observe(docElem, {
							childList: true,
							subtree: true,
							attributes: true,
						});
					}

					addEventListener('hashchange', throttledCheckElements, true);

					//, 'fullscreenchange'
					[
						'focus',
						'mouseover',
						'click',
						'load',
						'transitionend',
						'animationend',
					].forEach(function (name) {
						document.addEventListener(name, throttledCheckElements, true);
					});

					if (/d$|^c/.test(document.readyState)) {
						onload();
					} else {
						addEventListener('load', onload);
						document.addEventListener('DOMContentLoaded', throttledCheckElements);
						setTimeout(onload, 20000);
					}

					if (lazysizes.elements.length) {
						checkElements();
						rAF._lsFlush();
					} else {
						throttledCheckElements();
					}
				},
				checkElems: throttledCheckElements,
				unveil: unveilElement,
				_aLSL: altLoadmodeScrollListner,
			};
		})();

		var autoSizer = (function () {
			var autosizesElems;

			var sizeElement = rAFIt(function (elem, parent, event, width) {
				var sources, i, len;
				elem._lazysizesWidth = width;
				width += 'px';

				elem.setAttribute('sizes', width);

				if (regPicture.test(parent.nodeName || '')) {
					sources = parent.getElementsByTagName('source');
					for (i = 0, len = sources.length; i < len; i++) {
						sources[i].setAttribute('sizes', width);
					}
				}

				if (!event.detail.dataAttr) {
					updatePolyfill(elem, event.detail);
				}
			});
			var getSizeElement = function (elem, dataAttr, width) {
				var event;
				var parent = elem.parentNode;

				if (parent) {
					width = getWidth(elem, parent, width);
					event = triggerEvent(elem, 'lazybeforesizes', {
						width: width,
						dataAttr: !!dataAttr,
					});

					if (!event.defaultPrevented) {
						width = event.detail.width;

						if (width && width !== elem._lazysizesWidth) {
							sizeElement(elem, parent, event, width);
						}
					}
				}
			};

			var updateElementsSizes = function () {
				var i;
				var len = autosizesElems.length;
				if (len) {
					i = 0;

					for (; i < len; i++) {
						getSizeElement(autosizesElems[i]);
					}
				}
			};

			var debouncedUpdateElementsSizes = debounce(updateElementsSizes);

			return {
				_: function () {
					autosizesElems = document.getElementsByClassName(
						lazySizesCfg.autosizesClass
					);
					addEventListener('resize', debouncedUpdateElementsSizes);
				},
				checkElems: debouncedUpdateElementsSizes,
				updateElem: getSizeElement,
			};
		})();

		var init = function () {
			if (!init.i && document.getElementsByClassName) {
				init.i = true;
				autoSizer._();
				loader._();
			}
		};

		setTimeout(function () {
			if (lazySizesCfg.init) {
				init();
			}
		});

		lazysizes = {
			cfg: lazySizesCfg,
			autoSizer: autoSizer,
			loader: loader,
			init: init,
			uP: updatePolyfill,
			fire: triggerEvent,
			gW: getWidth,
			rAF: rAF,
		};

		return lazysizes;
	};

	window.lazySizes = factory();

	window.lazySizesConfig = window.lazySizesConfig || {};
	window.lazySizesConfig.preloadAfterLoad = true;

	function install (factory) {
		var globalInstall = function () {
			factory(window.lazySizes);
			window.removeEventListener('lazyunveilread', globalInstall, true);
		};

		if (window.lazySizes) {
			globalInstall();
		} else {
			window.addEventListener('lazyunveilread', globalInstall, true);
		}
	}

	function aspectRatio (lazySizes) {
		if (!window.addEventListener) {
			return;
		}

		var forEach = Array.prototype.forEach;

		var imageRatio;

		var regPicture = /^picture$/i;
		var aspectRatioAttr = 'data-aspectratio';
		var aspectRatioSel = 'img[' + aspectRatioAttr + ']';

		var matchesMedia = function (media) {
			if (window.matchMedia) {
				matchesMedia = function (media) {
					return !media || (matchMedia(media) || {}).matches;
				};
			} else if (window.Modernizr && Modernizr.mq) {
				return !media || Modernizr.mq(media);
			} else {
				return !media;
			}
			return matchesMedia(media);
		};

		var lazySizesConfig = lazySizes.cfg;

		function AspectRatio() {
			this.ratioElems = document.getElementsByClassName('lazyaspectratio');
			this._setupEvents();
			this.processImages();
		}

		AspectRatio.prototype = {
			_setupEvents: function () {
				var module = this;

				var addRemoveAspectRatio = function (elem) {
					if (elem.naturalWidth < 36) {
						module.addAspectRatio(elem, true);
					} else {
						module.removeAspectRatio(elem, true);
					}
				};
				var onload = function () {
					module.processImages();
				};

				document.addEventListener(
					'load',
					function (e) {
						if (e.target.getAttribute && e.target.getAttribute(aspectRatioAttr)) {
							addRemoveAspectRatio(e.target);
						}
					},
					true
				);

				addEventListener(
					'resize',
					(function () {
						var timer;
						var resize = function () {
							forEach.call(module.ratioElems, addRemoveAspectRatio);
						};

						return function () {
							clearTimeout(timer);
							timer = setTimeout(resize, 99);
						};
					})()
				);

				document.addEventListener('DOMContentLoaded', onload);

				addEventListener('load', onload);
			},
			processImages: function (context) {
				var elements, i;

				if (!context) {
					context = document;
				}

				if ('length' in context && !context.nodeName) {
					elements = context;
				} else {
					elements = context.querySelectorAll(aspectRatioSel);
				}

				for (i = 0; i < elements.length; i++) {
					if (elements[i].naturalWidth > 36) {
						this.removeAspectRatio(elements[i]);
						continue;
					}
					this.addAspectRatio(elements[i]);
				}
			},
			getSelectedRatio: function (img) {
				var i, len, sources, customMedia, ratio;
				var parent = img.parentNode;
				if (parent && regPicture.test(parent.nodeName || '')) {
					sources = parent.getElementsByTagName('source');

					for (i = 0, len = sources.length; i < len; i++) {
						customMedia =
							sources[i].getAttribute('data-media') ||
							sources[i].getAttribute('media');

						if (lazySizesConfig.customMedia[customMedia]) {
							customMedia = lazySizesConfig.customMedia[customMedia];
						}

						if (matchesMedia(customMedia)) {
							ratio = sources[i].getAttribute(aspectRatioAttr);
							break;
						}
					}
				}

				return ratio || img.getAttribute(aspectRatioAttr) || '';
			},
			parseRatio: (function () {
				var regRatio = /^\s*([+\d\.]+)(\s*[\/x]\s*([+\d\.]+))?\s*$/;
				var ratioCache = {};
				return function (ratio) {
					var match;

					if (!ratioCache[ratio] && (match = ratio.match(regRatio))) {
						if (match[3]) {
							ratioCache[ratio] = match[1] / match[3];
						} else {
							ratioCache[ratio] = match[1] * 1;
						}
					}

					return ratioCache[ratio];
				};
			})(),
			addAspectRatio: function (img, notNew) {
				var ratio;
				var width = img.offsetWidth;
				var height = img.offsetHeight;

				if (!notNew) {
					img.classList.add('lazyaspectratio');
				}

				if (width < 36 && height <= 0) {
					if (width || (height && window.console)) {
						console.log(
							'Define width or height of image, so we can calculate the other dimension'
						);
					}
					return;
				}

				ratio = this.getSelectedRatio(img);
				ratio = this.parseRatio(ratio);

				if (ratio) {
					if (width) {
						img.style.height = width / ratio + 'px';
					} else {
						img.style.width = height * ratio + 'px';
					}
				}
			},
			removeAspectRatio: function (img) {
				img.classList.remove('lazyaspectratio');
				img.style.height = '';
				img.style.width = '';
				img.removeAttribute(aspectRatioAttr);
			},
		};

		imageRatio = new AspectRatio();

		window.imageRatio = imageRatio;
	}

	install(aspectRatio);

	function _unsupportedIterableToArray(o, minLen) {
	  if (!o) return;
	  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
	  var n = Object.prototype.toString.call(o).slice(8, -1);
	  if (n === "Object" && o.constructor) n = o.constructor.name;
	  if (n === "Map" || n === "Set") return Array.from(o);
	  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
	}

	function _arrayLikeToArray(arr, len) {
	  if (len == null || len > arr.length) len = arr.length;

	  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

	  return arr2;
	}

	function _createForOfIteratorHelper(o, allowArrayLike) {
	  var it;

	  if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) {
	    if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
	      if (it) o = it;
	      var i = 0;

	      var F = function () {};

	      return {
	        s: F,
	        n: function () {
	          if (i >= o.length) return {
	            done: true
	          };
	          return {
	            done: false,
	            value: o[i++]
	          };
	        },
	        e: function (e) {
	          throw e;
	        },
	        f: F
	      };
	    }

	    throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
	  }

	  var normalCompletion = true,
	      didErr = false,
	      err;
	  return {
	    s: function () {
	      it = o[Symbol.iterator]();
	    },
	    n: function () {
	      var step = it.next();
	      normalCompletion = step.done;
	      return step;
	    },
	    e: function (e) {
	      didErr = true;
	      err = e;
	    },
	    f: function () {
	      try {
	        if (!normalCompletion && it.return != null) it.return();
	      } finally {
	        if (didErr) throw err;
	      }
	    }
	  };
	}

	// Check if event listener once is supported
	var onceSupported = false;

	try {
	  var options = {
	    get once() {
	      // This function will be called when the browser
	      //   attempts to access the once property.
	      onceSupported = true;
	      return false;
	    }

	  };
	  window.addEventListener('test', null, options);
	  window.removeEventListener('test', null, options);
	} catch (err) {
	  onceSupported = false;
	}

	function loadImages() {
	  var nativeLoadingImages = document.querySelectorAll('img.lazyloadnative');
	  nativeLoadingImages.forEach(processImage);

	  if (!('MutationObserver' in window)) {
	    return;
	  } // Prepare MutationObserver

	  /**
	   * @type {MutationObserverInit}
	   */


	  var config = {
	    childList: true,
	    subtree: true
	  };
	  /**
	   * Callback to execute when mutations are observed
	   * @type {MutationCallback}
	   */

	  var callback = function callback(mutationsList) {
	    var _iterator = _createForOfIteratorHelper(mutationsList),
	        _step;

	    try {
	      for (_iterator.s(); !(_step = _iterator.n()).done;) {
	        var mutation = _step.value;
	        mutation.addedNodes.forEach(processImage);
	      }
	    } catch (err) {
	      _iterator.e(err);
	    } finally {
	      _iterator.f();
	    }
	  };

	  var observer = new MutationObserver(callback);
	  observer.observe(document.body, config);
	}
	/**
	 * Process an image element
	 * @param {HTMLImageElement} image The image element being processed
	 */


	function processImage(image) {
	  if (image.nodeName !== 'IMG' || !image.classList.contains('lazyloadnative')) {
	    return;
	  }

	  if (!('loading' in HTMLImageElement.prototype)) {
	    image.classList.remove('lazyloadnative');
	    image.classList.add('lazyload');
	    return;
	  }

	  image.setAttribute('src', image.getAttribute('data-src'));
	  image.setAttribute('loading', 'lazy');

	  if (image.complete) {
	    showImage(image);
	  } else {
	    image.addEventListener('load', function () {
	      return showImage(image);
	    }, onceSupported ? {
	      once: true
	    } : false);
	  }
	}

	function showImage(image) {
	  image.classList.remove('lazyloadnative');
	  image.classList.add('lazyloaded');
	}

	document.addEventListener('DOMContentLoaded', loadImages);

}());
