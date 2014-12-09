/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
/*
Application constructor
*/
initialize: function() {
this.bindEvents();
console.log("Starting P2P app");
},
/*
bind any events that are required on startup to listeners:
*/
bindEvents: function() {
document.addEventListener('deviceready', this.onDeviceReady, false);
sampleField.addEventListener('change', app.showSampleData, false);
// modify the form so it doesn't generate a submit event:
document.forms[0].onsubmit = function(evt) {
evt.preventDefault(); // don't submit
payloadField.focus(); // put the payload field in focus
};
// if either type or payload is changed, update the share:
typeField.onchange = app.shareMessage;
payloadField.onchange = app.shareMessage;
},
/*
this runs when the device is ready for user interaction:
*/
onDeviceReady: function() {
var option;
// populate the sampleField from the data array
sampleField.innerHTML = "";
for (var i = 0; i < data.length; i++) {
option = document.createElement("option"); // make an option element
option.value = i; // give it this number
option.innerHTML = data[i].name; // get the data object
if (i === 0) { // select the first element
option.selected = true;
}
sampleField.appendChild(option); // add this to sampleField
}
app.showSampleData();
},
/*
Share the message from the form via peer-to-peer:
*/
shareMessage: function () {
// get the MIME-type, and payload from the form
// and create a new record:
var payloadType = typeField.value,
payloadData = payloadField.value,
kind = kindField.value,
record;
app.clear(); // clear the message div
app.display("Publishing message"); // display the notification
// use a different ndef helper to format the message
// depending on the kind:
switch (kind) {
case "text":
record = ndef.textRecord(payloadData);
break;
case "uri":
record = ndef.uriRecord(payloadData);
break;
case "mime":
record = ndef.mimeMediaRecord(payloadType, payloadData);
break;
case "external":
record = ndef.record(ndef.TNF_EXTERNAL_TYPE, payloadType, [], ...);
break;
case "empty":
record = ndef.emptyRecord();
break;
default:
alert("ERROR: can't build record");
}
console.log(JSON.stringify(record));
// share the message:
nfc.share(
[record], // NDEF message to share
function () { // success callback
navigator.notification.vibrate(100);
app.display("Success! Message sent to peer.");
},
function (reason) { // failure callback
app.display("Failed to share message " + reason);
});
},
/*
Stop sharing:
*/
unshareMessage: function () {
// stop sharing this message:
nfc.unshare(
function () { // success callback
navigator.notification.vibrate(100);
app.clear();
app.display("message is no longer shared");
},
function (reason) { // failure callback
app.display("Failed to unshare message " + reason);
});
},
/*
Get data from the data array and put it in the form fields:
*/
showSampleData: function() {
// get the type and payload from the form
var index = sampleField.value,
record = data[index];
// fill form with the data from the record:
kindField.value = record.kind;
typeField.value = record.type;
payloadField.value = record.data;
// hide type for kinds that don't need it
if (typeof record.type === 'string') {
typeDiv.style.display = "";
} else {
typeDiv.style.display = "none";
}
app.shareMessage();
},
/*
appends @message to the message div:
*/
display: function(message) {
var label = document.createTextNode(message),
lineBreak = document.createElement("br");
messageDiv.appendChild(lineBreak); // add a line break
messageDiv.appendChild(label); // add the text
},
/*
clears the message div:
*/
clear: function() {
messageDiv.innerHTML = "";
},
}; // end of app
