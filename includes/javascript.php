		<script type="text/javascript">
			const api = {
				setRequestParameters: function(requestParameters, mergeRequestParameters) {
					if (typeof requestParameters == "object") {
						for (let requestParameterKey in requestParameters) {
							Object.defineProperty(apiRequestParameters, requestParameterKey, {
								configurable: true,
								enumerable: true,
								value: requestParameters[requestParameterKey],
								writable: false
							});
						}
					}
				},
				sendRequest: function(callback) {
					let request = new XMLHttpRequest();
					request.open("POST", window.location.href, true);
					request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					request.send("encodedData=" + encodeURIComponent(JSON.stringify(apiRequestParameters)));
					request.onload = function(response) {
						if (response.target.status != 200) {
							let globalMessageElement = elements.get(".message[name=\"global\"]");
							elements.html(globalMessageElement, "There was an error processing the request, try again.");
							elements.removeClass(globalMessageElement, "hidden");
						} else {
							response = JSON.parse(response.target.response);

							if (typeof response.redirect == "string") {
								window.location.href = response.redirect;
							} else {
								callback(response);
							}
						}
					};
				}
			};
			const elements = {
				addClass: function(selector, className) {
					const addClass = function(selectedElement, className) {
						selectedElement.classList.add(className);
					};

					if (typeof selector == "object") {
						addClass(selector, className);
					}

					if (typeof selector == "string") {
						selectAllElements(selector, function(selectedElementKey, selectedElement) {
							addClass(selectedElement, className);
						});
					}
				},
				addEventListener: function(selector, listener) {
					let element = selector;
					let listenerName = listener.type + "Listener";

					if (typeof selector == 'string') {
						element = document.querySelector(selector);
					}

					if (typeof listener.name == "string") {
						listenerName = listener.name;
					}

					if (typeof element[listenerName] != "undefined") {
						element.removeEventListener(listener.type, element[listenerName]);
					}

					element[listenerName] = listener.method;
					element.addEventListener(listener.type, element[listenerName]);
				},
				get: function(selector) {
					return (typeof selector == 'object' ? selector : document.querySelector(selector));
				},
				getAttribute: function(selector, attribute) {
					const element = (typeof selector == "object" ? selector : document.querySelector(selector));
					let value = "";

					if (
						element &&
						element.hasAttribute(attribute)
					) {
						value = element.getAttribute(attribute);
					}

					return value;
				},
				hasAttribute: function(selector, attribute) {
					const element = (typeof selector == "object" ? selector : document.querySelector(selector));

					if (
						element &&
						element.hasAttribute(attribute)
					) {
						return true;
					}

					return false;
				},
				hasClass: function(selector, className) {
					const hasClass = function(selectedElement, className) {
						return selectedElement.classList.contains(className);
					};
					let elementHasClass = false;

					if (typeof selector == "object") {
						elementHasClass = hasClass(selector, className);
					}

					if (typeof selector == "string") {
						selectAllElements(selector, function(selectedElementKey, selectedElement) {
							if (hasClass(selectedElement, className)) {
								elementHasClass = true;
							}
						});
					}

					return elementHasClass;
				},
				html: function(selector, value) {
					let element = (typeof selector == "object" ? selector : document.querySelector(selector));

					if (!element) {
						return false;
					}

					if (typeof value != "undefined") {
						if (typeof selector == "object") {
							element.innerHTML = value;
						}

						if (typeof selector == "string") {
							selectAllElements(selector, function(selectedElementKey, selectedElement) {
								selectedElement.innerHTML = value;
							});
						}
					}

					return value || element.innerHTML;
				},
				removeAttribute: function(selector, attribute) {
					const removeAttribute = function(selectedElement, attribute, value) {
						if (selectedElement.hasAttribute(attribute)) {
							selectedElement.removeAttribute(attribute, value);
						}
					};

					if (typeof selector == "object") {
						removeAttribute(selector, attribute);
					}

					if (typeof selector == "string") {
						selectAllElements(selector, function(selectedElementKey, selectedElement) {
							removeAttribute(selectedElement, attribute);
						});
					}
				},
				removeClass: function(selector, className) {
					const removeClass = function(selectedElement, className) {
						selectedElement.classList.remove(className);
					};

					if (typeof selector == "object") {
						removeClass(selector, className);
					}

					if (typeof selector == "string") {
						selectAllElements(selector, function(selectedElementKey, selectedElement) {
							removeClass(selectedElement, className);
						});
					}
				},
				setAttribute: function(selector, attribute, value) {
					const setAttribute = function(selectedElement, attribute, value) {
						if (selectedElement) {
							selectedElement.setAttribute(attribute, value);
						}
					};

					if (typeof selector == "object") {
						setAttribute(selector, attribute, value);
					}

					if (typeof selector == "string") {
						selectAllElements(selector, function(selectedElementKey, selectedElement) {
							setAttribute(selectedElement, attribute, value);
						});
					}
				}
			};
			const hexadecimalCharacters = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"];

			const onDocumentReady = function(callback) {
				if (document.readyState != "complete") {
					setTimeout(function() {
						onDocumentReady(callback);
					}, 10);
				} else {
					callback();
				}
			};

			const render = function(callback) {
				setTimeout(function() {
					callback();
				}, 0);
			};

			const selectAllElements = function(selector, callback) {
				let response = [];
				let nodeList = document.querySelectorAll(selector);

				if (nodeList.length) {
					response = Object.entries(nodeList);
				}

				if (typeof callback === 'function') {
					for (let selectedElementKey in response) {
						callback(selectedElementKey, response[selectedElementKey][1]);
					}
				}

				return response;
			};

			const AvolittyHasher = function(a) {
				let b = [];
				let c = " ";
				let d = 64;
				let e = 2;
				let f = 0;
				let g = 0;

				while (d != f) {
					b[f] = 0;
					f++;
				}

				f = 0;
				a += c;
				f = a.length;

				while (f != 0) {
					f--;
					e = a.charCodeAt(f) + (((e >> 1) + e) & 65535) + 2;

					if (g == 0) {
						g = d - 1;
					} else {
						g--;
					}

					b[g] = (b[g] + e) & 15;
				}

				a = "";

				while (d != 0) {
					d--;
					b[d] = e;
					e = (b[d] + b[f] + (((d + e) >> 1) + e) & 65535) + 2;
					b[f] = e;
					f++;
					a += hexadecimalCharacters[e & 15];
				}

				return a;
			};

			let apiRequestParameters = {};

			if (
				(
					typeof Element.prototype.addEventListener == "undefined" ||
					typeof Element.prototype.removeEventListener == "undefined"
				) &&
				(this.attachEvent && this.detachEvent)
			) {
				Element.prototype.addEventListener = function (event, callback) {
					event = "on" + event;
					return this.attachEvent(event, callback);
				};
				Element.prototype.removeEventListener = function (event, callback) {
					event = "on" + event;
					return this.detachEvent(event, callback);
				};
			}

			if (!Object.entries) {
				Object.entries = function(object) {
					if (typeof object != "object") {
						return false;
					}

					let response = [];

					for (let objectKey in object) {
						if (object.hasOwnProperty(objectKey)) {
							response.push([objectKey, object[objectKey]]);
						}
					}

					return response;
				};
			}

			onDocumentReady(function() {
				let redirectElement = elements.get(".redirect");

				if (redirectElement) {
					let redirect = redirectElement.innerText;

					if (redirect) {
						window.location.href = redirect;
					}
				}

				let sessionId = "";

				if (navigator.cookieEnabled) {
					let cookiesIndex = document.cookie.indexOf("sessionId=") + 10;

					if (cookiesIndex == 9) {
						document.cookie = "sessionId=" + AvolittyHasher(Date.now() + Math.random() + navigator.userAgent) + "; domain=avolitty.com; max-age=100000000; path=/; samesite;";
						cookiesIndex = document.cookie.indexOf("sessionId=") + 10;
					}

					let sessionIdIndex = 0;

					while (sessionIdIndex != 64) {
						sessionIdIndex++;
						sessionId += document.cookie[cookiesIndex];
						cookiesIndex++;
					}
				}

				api.setRequestParameters({
					sessionId: sessionId
				});

				if (elements.get(".form")) {
					const processForm = function() {
						const outputElement = elements.get(".form .output");
						let input = {};
						selectAllElements(".form input, .form select, .form textarea", function(selectedElementKey, selectedElement) {
							input[selectedElement.getAttribute("name")] = selectedElement.value;
						});
						selectAllElements(".form .checkbox", function(selectedElementKey, selectedElement) {
							input[selectedElement.getAttribute("name")] = selectedElement.getAttribute("checked");
						});
						api.setRequestParameters({
							input: input
						});
						elements.addClass(".message", "hidden");

						if (outputElement) {
							elements.addClass(".form .output div", "hidden");
							elements.removeClass(outputElement, "hidden");
							elements.html(".form .output .message", "Processing request&hellip;");
							elements.removeClass(".form .output .message", "hidden");
						}

						api.sendRequest(function(response) {
							if (response.output) {
								let selectedElementValue;

								selectAllElements(".form .output input", function(selectedElementKey, selectedElement) {
									selectedElementValue = response.output[selectedElement.getAttribute("name")];

									if (elements.hasAttribute(selectedElement, "validation")) {
										if (selectedElementValue == 0) {
											selectedElementValue = "valid";
										} else {
											selectedElementValue = "invalid";
										}
									}

									selectedElement.value = selectedElementValue;
								});
								selectAllElements(".form .output textarea", function(selectedElementKey, selectedElement) {
									selectedElementValue = response.output[selectedElement.getAttribute("name")];

									if (typeof selectedElementValue == "object") {
										selectedElementValue = selectedElementValue.join("\n");
									}

									selectedElement.innerHTML = selectedElementValue;
									selectedElement.value = selectedElementValue;
								});
								elements.addClass(".form .output .message", "hidden");
								elements.removeClass(".form .output div", "hidden");
							} else {
								for (let messageKey in response.messages) {
									let messageElement = elements.get(".message[name=\"" + messageKey + "\"]");
									elements.html(messageElement, response.messages[messageKey]);
									elements.removeClass(messageElement, "hidden");
								}

								if (response.messages.output) {
									elements.removeClass(".form .output .message", "hidden");
								} else {
									if (outputElement) {
										 elements.addClass(outputElement, "hidden");
									}
								}
							}
						});
					}

					selectAllElements(".form input, .form select", function(selectedElementKey, selectedElement) {
						elements.addEventListener(selectedElement, {
							method: function() {
								if (event.key == "Enter") {
									processForm();
								}
							},
							type: "keydown"
						});
					});
					selectAllElements(".form .button", function(selectedElementKey, selectedElement) {
						elements.addEventListener(selectedElement, {
							method: function() {
								processForm();
							},
							type: "click"
						});
					});
				}
			});
		</script>
