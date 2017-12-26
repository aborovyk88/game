/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("var CACHE = 'network-or-cache-v1';\nvar timeout = 400;\n\nself.addEventListener('install', function (event) {\n    console.log('Installed');\n    event.waitUntil(\n        caches.open(CACHE).then(function (cache) { return cache.addAll([\n                '/js/app.js',\n                '/js/game.js',\n                '/js/login.js',\n                '/js/user-list.js',\n                '/js/user-manage.js',\n\n                '/css',\n\n                '/fonts'\n            ]); }\n        ));\n});\n\nself.addEventListener('activate', function (event) {\n    console.log('Activated');\n});\n\nself.addEventListener('fetch', function (event) {\n    console.log('Loading query to server');\n    event.respondWith(fromNetwork(event.request, timeout)\n        .catch(function (err) {\n            return fromCache(event.request);\n        }));\n});\n\nfunction fromNetwork(request, timeout) {\n    return new Promise(function (fulfill, reject) {\n        var timeoutId = setTimeout(reject, timeout);\n        fetch(request).then(function (response) {\n            clearTimeout(timeoutId);\n            fulfill(response);\n        }, reject);\n    });\n}\n\nfunction fromCache(request) {\n    return caches.open(CACHE).then(function (cache) { return cache.match(request).then(function (matching) { return matching || Promise.reject('no-match'); }\n        ); });\n}\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL3N3LmpzP2Y1MDYiXSwic291cmNlc0NvbnRlbnQiOlsiY29uc3QgQ0FDSEUgPSAnbmV0d29yay1vci1jYWNoZS12MSc7XG5jb25zdCB0aW1lb3V0ID0gNDAwO1xuXG5zZWxmLmFkZEV2ZW50TGlzdGVuZXIoJ2luc3RhbGwnLCAoZXZlbnQpID0+IHtcbiAgICBjb25zb2xlLmxvZygnSW5zdGFsbGVkJyk7XG4gICAgZXZlbnQud2FpdFVudGlsKFxuICAgICAgICBjYWNoZXMub3BlbihDQUNIRSkudGhlbigoY2FjaGUpID0+IGNhY2hlLmFkZEFsbChbXG4gICAgICAgICAgICAgICAgJy9qcy9hcHAuanMnLFxuICAgICAgICAgICAgICAgICcvanMvZ2FtZS5qcycsXG4gICAgICAgICAgICAgICAgJy9qcy9sb2dpbi5qcycsXG4gICAgICAgICAgICAgICAgJy9qcy91c2VyLWxpc3QuanMnLFxuICAgICAgICAgICAgICAgICcvanMvdXNlci1tYW5hZ2UuanMnLFxuXG4gICAgICAgICAgICAgICAgJy9jc3MnLFxuXG4gICAgICAgICAgICAgICAgJy9mb250cydcbiAgICAgICAgICAgIF0pXG4gICAgICAgICkpO1xufSk7XG5cbnNlbGYuYWRkRXZlbnRMaXN0ZW5lcignYWN0aXZhdGUnLCAoZXZlbnQpID0+IHtcbiAgICBjb25zb2xlLmxvZygnQWN0aXZhdGVkJyk7XG59KTtcblxuc2VsZi5hZGRFdmVudExpc3RlbmVyKCdmZXRjaCcsIChldmVudCkgPT4ge1xuICAgIGNvbnNvbGUubG9nKCdMb2FkaW5nIHF1ZXJ5IHRvIHNlcnZlcicpO1xuICAgIGV2ZW50LnJlc3BvbmRXaXRoKGZyb21OZXR3b3JrKGV2ZW50LnJlcXVlc3QsIHRpbWVvdXQpXG4gICAgICAgIC5jYXRjaCgoZXJyKSA9PiB7XG4gICAgICAgICAgICByZXR1cm4gZnJvbUNhY2hlKGV2ZW50LnJlcXVlc3QpO1xuICAgICAgICB9KSk7XG59KTtcblxuZnVuY3Rpb24gZnJvbU5ldHdvcmsocmVxdWVzdCwgdGltZW91dCkge1xuICAgIHJldHVybiBuZXcgUHJvbWlzZSgoZnVsZmlsbCwgcmVqZWN0KSA9PiB7XG4gICAgICAgIGxldCB0aW1lb3V0SWQgPSBzZXRUaW1lb3V0KHJlamVjdCwgdGltZW91dCk7XG4gICAgICAgIGZldGNoKHJlcXVlc3QpLnRoZW4oKHJlc3BvbnNlKSA9PiB7XG4gICAgICAgICAgICBjbGVhclRpbWVvdXQodGltZW91dElkKTtcbiAgICAgICAgICAgIGZ1bGZpbGwocmVzcG9uc2UpO1xuICAgICAgICB9LCByZWplY3QpO1xuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBmcm9tQ2FjaGUocmVxdWVzdCkge1xuICAgIHJldHVybiBjYWNoZXMub3BlbihDQUNIRSkudGhlbigoY2FjaGUpID0+XG4gICAgICAgIGNhY2hlLm1hdGNoKHJlcXVlc3QpLnRoZW4oKG1hdGNoaW5nKSA9PlxuICAgICAgICAgICAgbWF0Y2hpbmcgfHwgUHJvbWlzZS5yZWplY3QoJ25vLW1hdGNoJylcbiAgICAgICAgKSk7XG59XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9zdy5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUdBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9");

/***/ }
/******/ ]);