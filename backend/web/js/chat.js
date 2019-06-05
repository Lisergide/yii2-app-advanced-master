/*jshint esversion: 6*/
/*jshint browser: true*/
"use strict";
let websocketPort = wsPort ? wsPort : 8080,
    conn = new WebSocket('ws://localhost:' + websocketPort),
    idMessages = 'chatMessages';

conn.onopen = function (e) {
    console.log("Connection established!");
};
conn.onerror = function (e) {
    console.log("Connection fail!");
};

const sendMsg = () => {
    const sendBtn = document.getElementById('sendBtn');
    const fieldMsg = document.getElementById('fieldMsg');
    sendBtn.addEventListener('click', (e) => {
        conn.send(fieldMsg.value);
        fieldMsg.value = '';
    });
};

conn.onmessage = function (e) {
    document.getElementById(idMessages).value = e.data +
        '\n' + document.getElementById(idMessages).value;
    console.log(e.data);

    const $el = $('li.messages-menu ul.menu li:first').clone();
    $el.find('p').text(e.data);
    $el.find('h4').text('Websocket user');
    $el.prependTo('li.messages-menu ul.menu');

    const cnt = $('li.messages-menu ul.menu li').length;
    $('li.messages-menu span.label-success').text(cnt);
    $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
};

sendMsg();


