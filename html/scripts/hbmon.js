var sock = null;
var ellog = null;
var reconnectTimer = null;
var reconnectDelay = 1000;
var MAX_LOG_LINES = 200;
var bridge_table = null;
var main_table = null;
var masters_table = null;
var opb_table = null;
var peers_table = null;

function setHtml(node, html) {
   if (node) {
      node.innerHTML = html;
   }
}

function clearTables() {
   setHtml(bridge_table, "");
   setHtml(main_table, "");
   setHtml(masters_table, "");
   setHtml(opb_table, "");
   setHtml(peers_table, "");
}

function connect() {
   var wsuri;

   if (reconnectTimer) {
      clearTimeout(reconnectTimer);
      reconnectTimer = null;
   }

   wsuri = ((window.location.protocol === "https:") ? "wss://" : "ws://") + window.location.hostname + ":9000";

   if (!("WebSocket" in window)) {
      log("Browser does not support WebSocket!");
      return;
   }

   sock = new WebSocket(wsuri);
   sock.onopen = function() {
      reconnectDelay = 1000;
      log("Connected to " + wsuri);
   };
   sock.onclose = function(e) {
      log("Connection closed (wasClean = " + e.wasClean + ", code = " + e.code + ", reason = '" + e.reason + "')");
      sock = null;
      clearTables();
      reconnectTimer = setTimeout(connect, reconnectDelay);
      reconnectDelay = Math.min(reconnectDelay * 2, 30000);
   };
   sock.onmessage = function(e) {
      var opcode = e.data.slice(0, 1);
      var message = e.data.slice(1);
      if (opcode == "b") {
         Bmsg(message);
      } else if (opcode == "c") {
         Cmsg(message);
      } else if (opcode == "i") {
         Imsg(message);
      } else if (opcode == "o") {
         Omsg(message);
      } else if (opcode == "p") {
         Pmsg(message);
      } else if (opcode == "l") {
         log(message);
      } else if (opcode == "q") {
         log(message);
         clearTables();
      } else {
         log("Unknown Message Received: " + message);
      }
   };
}

window.onload = function() {
   ellog = document.getElementById('log');
   bridge_table = document.getElementById('bridge');
   main_table = document.getElementById('main');
   masters_table = document.getElementById('masters');
   opb_table = document.getElementById('opb');
   peers_table = document.getElementById('peers');
   connect();
};

function Bmsg(_msg) { setHtml(bridge_table, _msg); }
function Cmsg(_msg) { setHtml(masters_table, _msg); }
function Imsg(_msg) { setHtml(main_table, _msg); }
function Omsg(_msg) { setHtml(opb_table, _msg); }
function Pmsg(_msg) { setHtml(peers_table, _msg); }

function log(_msg) {
   var lines;
   if (!ellog) {
      return;
   }
   ellog.appendChild(document.createTextNode(_msg + '\n'));
   lines = ellog.textContent.split('\n');
   if (lines.length > MAX_LOG_LINES) {
      ellog.textContent = lines.slice(lines.length - MAX_LOG_LINES).join('\n');
   }
   ellog.scrollTop = ellog.scrollHeight;
}
