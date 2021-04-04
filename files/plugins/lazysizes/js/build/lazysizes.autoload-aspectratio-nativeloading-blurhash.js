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

	function nativeLoading (lazySizes) {
		var isConfigSet = false;
		var oldPrematureUnveil = lazySizes.prematureUnveil;
		var cfg = lazySizes.cfg;
		var listenerMap = {
			focus: 1,
			mouseover: 1,
			click: 1,
			load: 1,
			transitionend: 1,
			animationend: 1,
			scroll: 1,
			resize: 1,
		};

		if (!cfg.nativeLoading) {
			cfg.nativeLoading = {};
		}

		if (
			!window.addEventListener ||
			!window.MutationObserver ||
			(!'loading' in HTMLImageElement.prototype && !'loading' in HTMLIFrameElement.prototype)
		) {
			return;
		}

		function disableEvents() {
			var loader = lazySizes.loader;
			var throttledCheckElements = loader.checkElems;
			var removeALSL = function () {
				setTimeout(function () {
					window.removeEventListener('scroll', loader._aLSL, true);
				}, 1000);
			};
			var currentListenerMap =
				typeof cfg.nativeLoading.disableListeners == 'object'
					? cfg.nativeLoading.disableListeners
					: listenerMap;

			if (currentListenerMap.scroll) {
				window.addEventListener('load', removeALSL);
				removeALSL();

				window.removeEventListener('scroll', throttledCheckElements, true);
			}

			if (currentListenerMap.resize) {
				window.removeEventListener('resize', throttledCheckElements, true);
			}

			Object.keys(currentListenerMap).forEach(function (name) {
				if (currentListenerMap[name]) {
					document.removeEventListener(name, throttledCheckElements, true);
				}
			});
		}

		function runConfig() {
			if (isConfigSet) {
				return;
			}
			isConfigSet = true;

			if ('loading' in HTMLImageElement.prototype && 'loading' in HTMLIFrameElement.prototype && cfg.nativeLoading.disableListeners) {
				if (cfg.nativeLoading.disableListeners === true) {
					cfg.nativeLoading.setLoadingAttribute = true;
				}

				disableEvents();
			}

			if (cfg.nativeLoading.setLoadingAttribute) {
				window.addEventListener(
					'lazybeforeunveil',
					function (e) {
						var element = e.target;

						if ('loading' in element && !element.getAttribute('loading')) {
							element.setAttribute('loading', 'lazy');
						}
					},
					true
				);
			}
		}

		lazySizes.prematureUnveil = function prematureUnveil(element) {
			if (!isConfigSet) {
				runConfig();
			}

			if (
				'loading' in element &&
				(cfg.nativeLoading.setLoadingAttribute ||
					element.getAttribute('loading')) &&
				(element.getAttribute('data-sizes') != 'auto' || element.offsetWidth)
			) {
				return true;
			}

			if (oldPrematureUnveil) {
				return oldPrematureUnveil(element);
			}
		};
	}

	install(nativeLoading);

	if (window.lazySizes) {
		window.lazySizes.cfg.nativeLoading.setLoadingAttribute = true;
	}

	function _classCallCheck(instance, Constructor) {
	  if (!(instance instanceof Constructor)) {
	    throw new TypeError("Cannot call a class as a function");
	  }
	}

	function _inherits(subClass, superClass) {
	  if (typeof superClass !== "function" && superClass !== null) {
	    throw new TypeError("Super expression must either be null or a function");
	  }

	  subClass.prototype = Object.create(superClass && superClass.prototype, {
	    constructor: {
	      value: subClass,
	      writable: true,
	      configurable: true
	    }
	  });
	  if (superClass) _setPrototypeOf(subClass, superClass);
	}

	function _getPrototypeOf(o) {
	  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
	    return o.__proto__ || Object.getPrototypeOf(o);
	  };
	  return _getPrototypeOf(o);
	}

	function _setPrototypeOf(o, p) {
	  _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
	    o.__proto__ = p;
	    return o;
	  };

	  return _setPrototypeOf(o, p);
	}

	function _isNativeReflectConstruct() {
	  if (typeof Reflect === "undefined" || !Reflect.construct) return false;
	  if (Reflect.construct.sham) return false;
	  if (typeof Proxy === "function") return true;

	  try {
	    Date.prototype.toString.call(Reflect.construct(Date, [], function () {}));
	    return true;
	  } catch (e) {
	    return false;
	  }
	}

	function _construct(Parent, args, Class) {
	  if (_isNativeReflectConstruct()) {
	    _construct = Reflect.construct;
	  } else {
	    _construct = function _construct(Parent, args, Class) {
	      var a = [null];
	      a.push.apply(a, args);
	      var Constructor = Function.bind.apply(Parent, a);
	      var instance = new Constructor();
	      if (Class) _setPrototypeOf(instance, Class.prototype);
	      return instance;
	    };
	  }

	  return _construct.apply(null, arguments);
	}

	function _isNativeFunction(fn) {
	  return Function.toString.call(fn).indexOf("[native code]") !== -1;
	}

	function _wrapNativeSuper(Class) {
	  var _cache = typeof Map === "function" ? new Map() : undefined;

	  _wrapNativeSuper = function _wrapNativeSuper(Class) {
	    if (Class === null || !_isNativeFunction(Class)) return Class;

	    if (typeof Class !== "function") {
	      throw new TypeError("Super expression must either be null or a function");
	    }

	    if (typeof _cache !== "undefined") {
	      if (_cache.has(Class)) return _cache.get(Class);

	      _cache.set(Class, Wrapper);
	    }

	    function Wrapper() {
	      return _construct(Class, arguments, _getPrototypeOf(this).constructor);
	    }

	    Wrapper.prototype = Object.create(Class.prototype, {
	      constructor: {
	        value: Wrapper,
	        enumerable: false,
	        writable: true,
	        configurable: true
	      }
	    });
	    return _setPrototypeOf(Wrapper, Class);
	  };

	  return _wrapNativeSuper(Class);
	}

	function _assertThisInitialized(self) {
	  if (self === void 0) {
	    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
	  }

	  return self;
	}

	function _possibleConstructorReturn(self, call) {
	  if (call && (typeof call === "object" || typeof call === "function")) {
	    return call;
	  }

	  return _assertThisInitialized(self);
	}

	function _createSuper(Derived) {
	  var hasNativeReflectConstruct = _isNativeReflectConstruct();

	  return function _createSuperInternal() {
	    var Super = _getPrototypeOf(Derived),
	        result;

	    if (hasNativeReflectConstruct) {
	      var NewTarget = _getPrototypeOf(this).constructor;

	      result = Reflect.construct(Super, arguments, NewTarget);
	    } else {
	      result = Super.apply(this, arguments);
	    }

	    return _possibleConstructorReturn(this, result);
	  };
	}

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

	// @ts-check

	/**
	 * @type {Function[]}
	 */
	var processingQueue = [];
	var currentlyProcessing = 0;
	var maxConcurrent = 2;
	/**
	 * Queue of actions to perform, with a limit on how many at the same time.
	 * Calling this function with a parameter add to the queue.
	 * Calling it without one will continue execution of the queue.
	 * @param {Function} [actionCallback] Function add to queue, and call when possible. Must call runAction without params when finished.
	 */

	function runAction(actionCallback) {
	  if (typeof actionCallback === 'function') {
	    processingQueue.push(actionCallback);
	  } else {
	    currentlyProcessing--;
	  }

	  while (currentlyProcessing < maxConcurrent && typeof processingQueue[0] === 'function') {
	    currentlyProcessing++;
	    var upNext = processingQueue.shift();
	    upNext();
	  }
	}

	var digitCharacters = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "#", "$", "%", "*", "+", ",", "-", ".", ":", ";", "=", "?", "@", "[", "]", "^", "_", "{", "|", "}", "~"];

	var decode83 = function decode83(str) {
	  var value = 0;

	  for (var i = 0; i < str.length; i++) {
	    var c = str[i];
	    var digit = digitCharacters.indexOf(c);
	    value = value * 83 + digit;
	  }

	  return value;
	};

	var utils = {};

	utils.sRGBToLinear = function (value) {
	  var v = value / 255;

	  if (v <= 0.04045) {
	    return v / 12.92;
	  } else {
	    return Math.pow((v + 0.055) / 1.055, 2.4);
	  }
	};

	utils.linearTosRGB = function (value) {
	  var v = Math.max(0, Math.min(1, value));

	  if (v <= 0.0031308) {
	    return Math.round(v * 12.92 * 255 + 0.5);
	  } else {
	    return Math.round((1.055 * Math.pow(v, 1 / 2.4) - 0.055) * 255 + 0.5);
	  }
	};

	utils.signPow = function (val, exp) {
	  return (val < 0 ? -1 : 1) * Math.pow(Math.abs(val), exp);
	};

	var ValidationError = /*#__PURE__*/function (_Error) {
	  _inherits(ValidationError, _Error);

	  var _super = _createSuper(ValidationError);

	  function ValidationError(message) {
	    var _this;

	    _classCallCheck(this, ValidationError);

	    _this = _super.call(this, message);
	    _this.name = 'ValidationError';
	    _this.message = message;
	    return _this;
	  }

	  return ValidationError;
	}( /*#__PURE__*/_wrapNativeSuper(Error));
	/**
	 * Returns an error message if invalid or undefined if valid
	 * @param blurhash
	 */


	var validateBlurhash = function validateBlurhash(blurhash) {
	  if (!blurhash || blurhash.length < 6) {
	    throw new ValidationError('The blurhash string must be at least 6 characters');
	  }

	  var sizeFlag = decode83(blurhash[0]);
	  var numY = Math.floor(sizeFlag / 9) + 1;
	  var numX = sizeFlag % 9 + 1;

	  if (blurhash.length !== 4 + 2 * numX * numY) {
	    throw new ValidationError("blurhash length mismatch: length is ".concat(blurhash.length, " but it should be ").concat(4 + 2 * numX * numY));
	  }
	};

	var decodeDC = function decodeDC(value) {
	  var intR = value >> 16;
	  var intG = value >> 8 & 255;
	  var intB = value & 255;
	  return [utils.sRGBToLinear(intR), utils.sRGBToLinear(intG), utils.sRGBToLinear(intB)];
	};

	var decodeAC = function decodeAC(value, maximumValue) {
	  var quantR = Math.floor(value / (19 * 19));
	  var quantG = Math.floor(value / 19) % 19;
	  var quantB = value % 19;
	  var rgb = [utils.signPow((quantR - 9) / 9, 2.0) * maximumValue, utils.signPow((quantG - 9) / 9, 2.0) * maximumValue, utils.signPow((quantB - 9) / 9, 2.0) * maximumValue];
	  return rgb;
	};

	var decode = function decode(blurhash, width, height, punch) {
	  validateBlurhash(blurhash);
	  punch = punch | 1;
	  var sizeFlag = decode83(blurhash[0]);
	  var numY = Math.floor(sizeFlag / 9) + 1;
	  var numX = sizeFlag % 9 + 1;
	  var quantisedMaximumValue = decode83(blurhash[1]);
	  var maximumValue = (quantisedMaximumValue + 1) / 166;
	  var colors = new Array(numX * numY);

	  for (var i = 0; i < colors.length; i++) {
	    if (i === 0) {
	      var value = decode83(blurhash.substring(2, 6));
	      colors[i] = decodeDC(value);
	    } else {
	      var _value = decode83(blurhash.substring(4 + i * 2, 6 + i * 2));

	      colors[i] = decodeAC(_value, maximumValue * punch);
	    }
	  }

	  var bytesPerRow = width * 4;
	  var pixels = new Uint8ClampedArray(bytesPerRow * height);

	  for (var y = 0; y < height; y++) {
	    for (var x = 0; x < width; x++) {
	      var r = 0;
	      var g = 0;
	      var b = 0;

	      for (var j = 0; j < numY; j++) {
	        for (var _i = 0; _i < numX; _i++) {
	          var basis = Math.cos(Math.PI * x * _i / width) * Math.cos(Math.PI * y * j / height);
	          var color = colors[_i + j * numX];
	          r += color[0] * basis;
	          g += color[1] * basis;
	          b += color[2] * basis;
	        }
	      }

	      var intR = utils.linearTosRGB(r);
	      var intG = utils.linearTosRGB(g);
	      var intB = utils.linearTosRGB(b);
	      pixels[4 * x + 0 + y * bytesPerRow] = intR;
	      pixels[4 * x + 1 + y * bytesPerRow] = intG;
	      pixels[4 * x + 2 + y * bytesPerRow] = intB;
	      pixels[4 * x + 3 + y * bytesPerRow] = 255; // alpha
	    }
	  }

	  return pixels;
	};

	// @ts-check

	/**
	 * @type {CanvasDataObject[]}
	 */
	var canvases = [];
	/**
	 * Object containing a canvas and related objects and data
	 * @typedef {Object} CanvasDataObject
	 * @property {HTMLCanvasElement|OffscreenCanvas} [element] The canvas element
	 * @property {CanvasRenderingContext2D|OffscreenCanvasRenderingContext2D} [ctx] The canvas rendering context
	 * @property {ImageData} [imageData] The ImageData object used to render images
	 * @property {boolean} [used] Whether this canvas is currently used
	 */

	/**
	 * Get a canvas from the pool, or create a new one if all are in use.
	 * @param {number} width The requested canvas width
	 * @param {number} height The requested canvas height
	 * @returns {CanvasDataObject} An object with a usable canvas
	 */

	function getCanvas(width, height) {
	  var unusedCanvases = canvases.filter(function (canvas) {
	    return canvas && canvas.used === false;
	  });
	  var canvas = unusedCanvases[0];

	  if (canvas) {
	    canvas.ctx.clearRect(0, 0, canvas.element.width, canvas.element.height);
	  } else {
	    canvas = {};

	    if (typeof window !== 'undefined' && window.document) {
	      canvas.element = document.createElement('canvas');
	    } else {
	      canvas.element = new OffscreenCanvas(width, height);
	    }

	    canvas.ctx = canvas.element.getContext('2d');
	    canvases.push(canvas);
	  }

	  canvas.element.width = width;
	  canvas.element.height = height;
	  canvas.imageData = canvas.ctx.createImageData(width, height);
	  canvas.used = true;
	  return canvas;
	}

	// @ts-check
	/**
	 * Decode Blurhash string and return as blob.
	 * @param {string} blurhash An encoded Blurhash string
	 * @param {number} width The width of the image
	 * @param {number} height The height of the image
	 * @param {getBlurhashCallback} callback Function to call with the decoded image blob when finished
	 */

	function getBlurhash(blurhash, width, height, callback) {
	  var pixels = decode(blurhash, width, height);
	  var canvas = getCanvas(width, height);
	  canvas.imageData.data.set(pixels);
	  canvas.ctx.putImageData(canvas.imageData, 0, 0);

	  if (typeof HTMLCanvasElement !== 'undefined' && canvas.element instanceof HTMLCanvasElement) {
	    // @ts-ignore
	    if (canvas.element.msToBlob) {
	      // @ts-ignore
	      callback(canvas.element.msToBlob());
	    } else {
	      canvas.element.toBlob(function (blob) {
	        canvas.used = false;
	        callback(blob);
	      });
	    }
	  } else if (typeof OffscreenCanvas !== 'undefined' && canvas.element instanceof OffscreenCanvas) {
	    canvas.element.convertToBlob().then(function (blob) {
	      canvas.used = false;
	      callback(blob);
	    });
	  }
	}
	/**
	 * Callback for when Blurhash image creation is complete
	 * @callback getBlurhashCallback
	 * @param {Blob} blob The decoded image blob
	 */

	// @ts-check

	/**
	 * @type {WorkerDataObject[]}
	 */
	var workers = [];
	var workerUrl;
	/**
	 * Sets the worker URL
	 * @param {string} url The url to the worker file
	 */

	function setWorkerUrl(url) {
	  workerUrl = url;
	}
	/**
	 * Object containing a worker and related objects and data
	 * @typedef {Object} WorkerDataObject
	 * @property {Worker} [worker] The worker object
	 * @property {boolean} [used] Whether this canvas is currently used
	 */

	/**
	 * Get a worker from the pool, or create a new one if all are in use.
	 * @param {EventListenerOrEventListenerObject} [onError] Function to assign as error handler
	 * @returns {WorkerDataObject} An object with a usable worker
	 */

	function getWorker(onError) {
	  var unusedWorkers = workers.filter(function (worker) {
	    return worker && worker.used === false;
	  });
	  var worker = unusedWorkers[0];

	  if (!worker) {
	    worker = {};
	    worker.worker = new Worker(workerUrl);

	    if (onError) {
	      worker.worker.addEventListener('error', onError, false);
	    }

	    workers.push(worker);
	  }

	  worker.used = true;
	  return worker;
	}

	var useWorker = 'Worker' in window && 'OffscreenCanvas' in window && 'convertToBlob' in OffscreenCanvas.prototype;

	function workerErrorListener(error) {
	  console.log(error);
	  useWorker = false;
	}

	function installWorker() {
	  if (useWorker) {
	    var script = document.currentScript;

	    if (script === null || script.getAttribute('src').indexOf('lazysizes') === -1) {
	      useWorker = false;
	      return;
	    }

	    var scriptSrcSplit = script.getAttribute('src').split('/');
	    scriptSrcSplit.pop();
	    var workerUrl = scriptSrcSplit.join('/') + '/blurhash-worker.min.js';
	    setWorkerUrl(workerUrl);
	    var worker = new Worker(workerUrl);
	    worker.addEventListener('error', workerErrorListener, false);
	    worker.terminate();
	  }
	}

	installWorker();

	function blurhashLoad() {
	  if (!('toBlob' in HTMLCanvasElement.prototype || 'msToBlob' in HTMLCanvasElement.prototype)) {
	    // No support for canvas.toBlob
	    return;
	  }

	  var blurhashImages = document.querySelectorAll('img[data-blurhash]');
	  blurhashImages.forEach(processImage);

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
	  if (image.nodeName !== 'IMG' || !image.dataset.blurhash || image.classList.contains('blurhashed')) {
	    return;
	  }

	  runAction(function imageAction() {
	    var width = parseInt(image.getAttribute('width'), 10) || 1;
	    var height = parseInt(image.getAttribute('height'), 10) || 1;

	    if (width <= 1 || height <= 1) {
	      if (image.dataset.aspectratio) {
	        var aspectratio = image.dataset.aspectratio.split('/');
	        width = parseInt(aspectratio[0], 10);
	        height = parseInt(aspectratio[1], 10);

	        if (width <= 25 || height <= 25) {
	          // Probably an actual aspect ratio, we can't handle that yet.
	          return;
	        }
	      } else {
	        return;
	      }
	    }

	    var _getComputedStyle = getComputedStyle(image.parentElement),
	        parentPosition = _getComputedStyle.position,
	        parentDisplay = _getComputedStyle.display;

	    var imageStyles = getComputedStyle(image);
	    var imagePosition = imageStyles.position;
	    var useFancySetup = true;

	    if (document.body.classList.contains('blurhash-no-fancy') || parentPosition === 'fixed' || parentPosition === 'sticky' || imagePosition === 'fixed' || imagePosition === 'sticky' || // Check if length of parent is more than 1
	    Array.prototype.slice.call(image.parentNode.children).filter(function (val) {
	      return val.nodeName !== 'NOSCRIPT';
	    }).length > 1) {
	      useFancySetup = false;
	    }
	    /**
	     * @type {HTMLImageElement}
	     */


	    var newImage;

	    if (useFancySetup) {
	      var containerNode = image.parentElement; // If image is wrapped in link, use link's parent

	      if (containerNode.nodeName === 'A' && parentDisplay === 'inline') {
	        containerNode = containerNode.parentElement;
	      }

	      containerNode.classList.add('blurhash-container'); // Make sure parent is either relative or absolute

	      if (parentPosition !== 'absolute') {
	        containerNode.classList.add('blurhash-container-relative');
	      } // Make sure image is either relative or absolute


	      if (imagePosition !== 'absolute') {
	        image.classList.add('blurhash-relative');
	      } // @ts-ignore


	      newImage = image.cloneNode();
	      newImage.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	      newImage.classList.add('blurhashing');
	      newImage.classList.remove('blurhash-relative');
	      newImage.classList.remove('lazyload');
	      newImage.classList.remove('lazyloadnative');
	      newImage.classList.remove('lazyloading'); // Cleanup attributes

	      newImage.removeAttribute('srcset');
	      newImage.removeAttribute('data-srcset');
	      newImage.removeAttribute('data-src');
	      newImage.removeAttribute('itemprop');
	      newImage.removeAttribute('id');
	      newImage.alt = '';
	      newImage.removeAttribute('data-aspectratio');
	      newImage.removeAttribute('data-blurhash');

	      if ('loading' in newImage) {
	        // @ts-ignore
	        newImage.loading = 'eager';
	      }

	      var direction = imageStyles.direction,
	          top = imageStyles.top;
	      var alignSide = direction === 'ltr' ? 'left' : 'right';

	      if (imageStyles[alignSide] === '0px' || imageStyles[alignSide] === 'auto') {
	        newImage.classList.add(alignSide);
	      } else {
	        newImage.style[alignSide] = imageStyles[alignSide];
	      }

	      if (top !== '0px' && top !== 'auto') {
	        newImage.style.top = top;
	      }

	      image.after(newImage);
	    } else {
	      if (image.classList.contains('lazyloadnative')) {
	        image.classList.remove('lazyloadnative');
	        image.classList.add('lazyload');
	      }

	      image.classList.add('blurhash');
	      image.classList.add('blurhashing');
	    }

	    var callback = function callback(blob) {
	      var url = URL.createObjectURL(blob);

	      if (useFancySetup) {
	        newImage.src = url; // To trigger fade transition

	        newImage.classList.remove('blurhashing');
	        newImage.classList.add('blurhashed'); // Remove element used for fancy blurhash and revoke url when image is loaded

	        function lazyloadedCallback() {
	          image.removeEventListener('lazyloaded', lazyloadedCallback); // Timeout is used to ensure animation is complete

	          setTimeout(function () {
	            URL.revokeObjectURL(url);
	            newImage.parentNode.removeChild(newImage);
	          }, 2000);
	        }

	        image.addEventListener('lazyloaded', lazyloadedCallback);
	      } else {
	        image.src = url;
	        image.classList.remove('blurhashing');
	        image.classList.add('blurhashed'); // Revoke url when image is loaded

	        function lazyloadedCallback() {
	          image.removeEventListener('lazyloaded', lazyloadedCallback); // Timeout is used to ensure animation is complete

	          setTimeout(function () {
	            URL.revokeObjectURL(url);
	          }, 2000);
	        }

	        image.addEventListener('lazyloaded', lazyloadedCallback);
	      }

	      runAction();
	    };

	    if (useWorker === true) {
	      var worker = getWorker(workerErrorListener);
	      worker.worker.postMessage([image.dataset.blurhash, width, height]);

	      worker.worker.onmessage = function (_ref) {
	        var blob = _ref.data;
	        callback(blob);
	        worker.used = false;
	      };
	    } else {
	      getBlurhash(image.dataset.blurhash, width, height, callback);
	    }
	  });
	}

	document.addEventListener('DOMContentLoaded', blurhashLoad);

}());
