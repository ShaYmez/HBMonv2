<?php
include_once '../include/config.php';
// Output CSS and not plain text
header("Content-type: text/css");
?>
.link <?php echo "{".THEME_COLOR."}\n"; ?>
.button <?php echo "{".THEME_COLOR."}\n"; ?>
.dropbtn <?php echo "{".THEME_COLOR."}\n"; ?>

#lact {
 height:<?php echo HEIGHT_ACTIVITY; ?>;
 width: 100%;
 border-collapse: collapse;
 border:none;
}
#rcorner {
  display: flex;
  align-items: center;
  justify-content: center;
  vertical-align: middle;
  text-align:center;
  justify-content: center;
  align-items: center;
  border-radius: 10px;
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border: 1px solid LightGrey;
  background: #e9e9e9;
  font: 12pt arial, sans-serif; 
  font-weight:bold;
  margin-top:2px;
  margin-right:0px;
  margin-left:0px;
  margin-bottom:0px;
  color:#002d62;
  white-space:normal;
  height: 100%;
  line-height:21px;
}
#rcornerh {
  display: flex;
  display: -webkit-flex;
  justify-content: center;
  align-items: center;
  border-radius:8px;
  -moz-border-radius:8px;
  -webkit-border-radius:8px;
  font: 9pt arial, sans-serif; 
  font-weight:bold;
  color:white;
  height:25px;
  line-height:25px;
  <?php echo THEME_COLOR."\n"; ?>
}

table, td, th {
  border: .5px solid #d0d0d0; 
  padding: 2px; 
  border-collapse: collapse;
  border-spacing: 0;
  text-align:center;}
tr.theme_color <?php echo "{".THEME_COLOR."}\n"; ?>
th.theme_color <?php echo "{".THEME_COLOR."}\n"; ?>

html {
    overflow: -moz-scrollbars-vertical; 
    overflow-y: scroll;
}


table.log {background-color: #f0f0f0; border-collapse: collapse; border: 1px solid #C1DAD7; width: 100%;}
th.log {height: 30px; text-align: center;}
tr:nth-child(even).log {background-color: #fafafa;text-align: center;}
td.log {font-family: Monospace; height: 20px;}


a:link {
  color: #0066ff;
  text-decoration: none;
}

/* visited link */
a:visited {
  color: #0066ff;
  text-decoration: none;
}

/* mouse over link */
a:hover {
  color: hotpink;
  text-decoration: underline;
}
/* selected link */
a:active {
  color: #0066ff;
  text-decoration: none;
}
.tooltip {
  position: relative;
  opacity: 1;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 280px;
  background-color: #6E6E6E;
  box-shadow: 4px 4px 6px #3b3b3b;
  color: #FFFFFF;
  text-align: left;
  border-radius: 6px;
  padding: 8px 0;
  left: 100%;
  opacity: 1;
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  right: 100%;
  opacity: 1;
  visibility: visible;
}
.button {
  border: none;
  padding: 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  font-weight: 500;
  margin: 4px 2px;
  border-radius: 8px;
  box-shadow: 0px 8px 10px rgba(0,0,0,0.1);
  cursor: pointer;
}
a.button:link,
a.button:visited,
a.button:hover,
a.button:active {
  text-decoration: none;
}
a.button.link:link,
a.button.link:visited,
a.button.link:active <?php echo "{".THEME_COLOR." text-decoration:none;}\n"; ?>

.link:hover {background-color:rgb(140,140,140);background: rgb(140,140,140); color:white;}  
.dropdown:hover .dropbtn {background-color:rgb(140,140,140);background: rgb(140,140,140); color:white;} 

.dropbtn {
  border: none;
  padding: 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  font-weight: 500;
  margin: 4px 2px;
  border-radius: 8px;
  box-shadow: 0px 8px 10px rgba(0,0,0,0.1);
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 140px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1000;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 6px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

.tg-login {
  margin: 12px auto 8px;
  display: inline-block;
  text-align: left;
}
.tg-login td {
  padding: 6px 8px;
  border: none;
  text-align: left;
  font: 10pt arial, sans-serif;
}
.tg-login input[type=text],
.tg-login input[type=password],
.tg-form input[type=text],
.tg-form input[type=number] {
  padding: 6px 8px;
  border: 1px solid #d0d0d0;
  border-radius: 8px;
  font: 10pt arial, sans-serif;
  background: #f9f9f9;
}
.tg-form {
  margin: 8px auto 10px;
}
.tg-logout {
  margin: 4px auto 0;
}
.tg-form input[type=number] {
  width: 120px;
}
.tg-form input[type=text] {
  width: 420px;
}
.tg-msg {
  color: #a00;
  font-weight: bold;
  margin: 8px 0 4px;
}
table.tg-table tr:nth-child(even) {
  background-color: #fafafa;
}
table.tg-table tr:hover {
  background-color: #eeeeee;
}
table.tg-table tr.tg-editing {
  background-color: #e8eef5;
}
.tg-actions form {
  display: inline;
}
.tg-actions .button {
  padding: 4px 10px;
  font-size: 12px;
  margin: 2px;
}
.tg-api {
  margin: 12px auto 10px;
  text-align: left;
  max-width: 980px;
}
.tg-api label {
  display: block;
  font: 10pt arial, sans-serif;
  font-weight: bold;
  color: #000;
  margin: 0 0 6px 4px;
}
.tg-api input[type=text] {
  width: 620px;
  max-width: 70%;
  padding: 6px 8px;
  border: 1px solid #d0d0d0;
  border-radius: 8px;
  font: 10pt arial, sans-serif;
  background: #f9f9f9;
  color: #000;
}
.tg-api-actions,
.tg-download-actions {
  display: inline;
}

/* Responsive page structure. Desktop dimensions intentionally match HBMonv2. */
.hbmon-page {
  text-align: center;
}
.hbmon-shell {
  width: 1100px;
  margin-left: auto;
  margin-right: auto;
}
.hbmon-header {
  text-align: center;
  margin-top: 5px;
}
.hbmon-logo {
  max-width: 100%;
  height: auto;
}
.hbmon-panel {
  width: 1050px;
  margin-left: 15px;
  margin-right: 15px;
  box-sizing: border-box;
}
.hbmon-live {
  min-width: 0;
}
.hbmon-activity-items {
  width: 100%;
  line-height: 1.5;
  white-space: normal;
  overflow-wrap: anywhere;
}
.hbmon-scroll {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.hbmon-mobile-only {
  display: none;
}
.hbmon-nav-toggle {
  display: none;
}
.hbmon-nav-links {
  text-align: center;
}
.hbmon-nav-separator {
  display: inline;
}
.hbmon-footer {
  overflow-wrap: anywhere;
}
.hbmon-system-info img {
  max-width: 100%;
  height: auto;
}
.hbmon-card,
.hbmon-card-row {
  box-sizing: border-box;
}
.hbmon-card-label {
  color: #464646;
  font-weight: 600;
}
.hbmon-slot {
  border: 1px solid #d0d0d0;
  border-radius: 8px;
  margin-top: 8px;
  overflow: hidden;
}
.hbmon-slot-head {
  display: flex;
  justify-content: space-between;
  gap: 8px;
  padding: 7px 9px;
  font-weight: bold;
}
.hbmon-slot-row {
  display: grid;
  grid-template-columns: 95px minmax(0, 1fr);
  gap: 8px;
  padding: 7px 9px;
  border-top: 1px solid rgba(0,0,0,.1);
  text-align: left;
}
.hbmon-qso-list {
  display: inline;
}
.hbmon-qso-chip {
  display: inline;
  white-space: nowrap;
}
.hbmon-qso-chip::before {
  content: "[";
}
.hbmon-qso-chip::after {
  content: "] ";
}

@media (max-width: 1119px) {
  html {
    overflow-y: auto;
  }
  body {
    margin: 0;
    overflow-x: hidden;
  }
  .hbmon-shell {
    width: calc(100% - 16px);
    max-width: 1100px;
    box-sizing: border-box;
  }
  .hbmon-header {
    margin-top: 5px;
  }
  .hbmon-panel,
  #main > fieldset,
  #masters > fieldset,
  #peers > fieldset,
  #opb > fieldset,
  #bridge > fieldset {
    width: 100%;
    max-width: 1050px;
    margin-left: auto;
    margin-right: auto;
  }
  .hbmon-system-info {
    width: calc(100% - 16px);
    margin-left: 8px;
    margin-right: 8px;
    box-sizing: border-box;
  }
  #main,
  #masters,
  #peers,
  #opb,
  #bridge {
    min-width: 0;
  }
  .hbmon-table-desktop {
    min-width: 760px;
  }
  .hbmon-footer {
    font-size: 12px;
    line-height: 1.45;
  }
}

@media (max-width: 767px) {
  .hbmon-shell {
    width: calc(100% - 12px);
  }
  .hbmon-header-version {
    margin-right: 4px !important;
  }
  .hbmon-report-name {
    margin: 8px 0 10px;
    line-height: 1.25;
  }
  .hbmon-panel,
  #main > fieldset,
  #masters > fieldset,
  #peers > fieldset,
  #opb > fieldset,
  #bridge > fieldset {
    padding: 7px;
  }
  .hbmon-nav {
    position: relative;
    z-index: 20;
  }
  .hbmon-nav-toggle {
    display: inline-block;
    min-width: 130px;
    min-height: 44px;
  }
  .hbmon-nav-links {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 6px;
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transform: translateY(-4px);
    visibility: hidden;
    transition: max-height .22s ease, opacity .18s ease, transform .18s ease;
  }
  .hbmon-nav-links.is-open {
    max-height: 520px;
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
    padding-top: 6px;
  }
  .hbmon-nav-separator {
    display: none;
  }
  .hbmon-nav-links .button {
    min-height: 44px;
    margin: 0;
    padding: 12px 6px;
    box-sizing: border-box;
  }
  .button:focus-visible,
  .hbmon-nav-toggle:focus-visible,
  input:focus-visible,
  summary:focus-visible {
    outline: 3px solid #ffbf47;
    outline-offset: 2px;
  }
  .hbmon-desktop-only {
    display: none !important;
  }
  .hbmon-mobile-only {
    display: block;
  }
  #lact {
    height: auto;
    min-height: <?php echo HEIGHT_ACTIVITY; ?>;
  }
  #rcorner {
    min-height: <?php echo HEIGHT_ACTIVITY; ?>;
    height: auto;
    padding: 8px;
    box-sizing: border-box;
    overflow-wrap: anywhere;
  }
  .hbmon-connected-list {
    margin-left: 8px !important;
    margin-right: 8px !important;
  }
  .hbmon-touch-list {
    display: grid;
    gap: 8px;
    margin: 8px 0;
  }
  .hbmon-touch-card,
  .hbmon-card {
    background: #f9f9f9;
    border: 1px solid #c7c7c7;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,.12);
    padding: 10px;
    text-align: left;
    overflow-wrap: anywhere;
  }
  details.hbmon-touch-card > summary {
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
  }
  details.hbmon-touch-card > summary::after {
    content: "+";
    margin-left: auto;
    font-size: 18px;
  }
  details.hbmon-touch-card[open] > summary::after {
    content: "\2212";
  }
  .hbmon-slot .hbmon-card-label {
    color: inherit;
  }
  .hbmon-card-header {
    <?php echo THEME_COLOR."\n"; ?>
    border-radius: 8px 8px 0 0;
    margin: -10px -10px 10px;
    padding: 10px;
    text-align: left;
    font-weight: bold;
  }
  .hbmon-card-meta {
    display: grid;
    grid-template-columns: minmax(92px, auto) minmax(0, 1fr);
    gap: 6px 10px;
    margin: 6px 0;
  }
  .hbmon-card-value {
    min-width: 0;
    text-align: right;
    overflow-wrap: anywhere;
  }
  .tooltip .tooltiptext {
    display: none !important;
  }
  .hbmon-responsive-table {
    display: block;
    width: 100%;
    border: 0;
    background: transparent !important;
  }
  .hbmon-responsive-table thead,
  .hbmon-responsive-table > tbody > tr.theme_color,
  .hbmon-responsive-table > tr.theme_color {
    display: none;
  }
  .hbmon-responsive-table tbody,
  .hbmon-responsive-table > tbody {
    display: block;
  }
  .hbmon-responsive-table colgroup {
    display: none;
  }
  .hbmon-responsive-table tr:not(.theme_color) {
    display: block;
    margin: 0 0 10px;
    border: 1px solid #c7c7c7;
    border-radius: 10px;
    background: #f9f9f9;
    box-shadow: 0 2px 5px rgba(0,0,0,.1);
    overflow: hidden;
  }
  .hbmon-responsive-table td {
    display: grid;
    grid-template-columns: minmax(95px, 38%) minmax(0, 1fr);
    gap: 10px;
    width: auto !important;
    min-height: 32px;
    padding: 8px 10px;
    border-width: 0 0 1px;
    text-align: right !important;
    overflow-wrap: anywhere;
    align-items: center;
  }
  .hbmon-responsive-table td:last-child {
    border-bottom: 0;
  }
  .hbmon-responsive-table td::before {
    content: attr(data-label);
    color: #464646;
    font-weight: 600;
    text-align: left;
  }
  .hbmon-responsive-table td.hbmon-qso-cell {
    display: block;
    text-align: left !important;
  }
  .hbmon-responsive-table td.hbmon-qso-cell::before {
    display: block;
    margin-bottom: 6px;
  }
  .hbmon-qso-list {
    display: grid;
    gap: 6px;
  }
  .hbmon-qso-chip {
    display: grid;
    grid-template-columns: 42px minmax(0, 1fr) auto;
    align-items: center;
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
    padding: 8px 10px;
    border: 1px solid #d0d0d0;
    border-radius: 8px;
    background: #fff;
    white-space: normal;
    text-align: left;
  }
  .hbmon-qso-chip::before,
  .hbmon-qso-chip::after {
    content: none;
  }
  .hbmon-qso-sep,
  .hbmon-qso-arrow {
    display: none;
  }
  .hbmon-qso-dir {
    font-weight: bold;
  }
  .hbmon-qso-call {
    min-width: 0;
    overflow-wrap: anywhere;
    text-align: left;
  }
  .hbmon-qso-tg {
    white-space: nowrap;
    font-weight: bold;
  }
  .hbmon-qso-idle {
    display: block;
    text-align: left;
    color: #666;
    font-weight: 600;
  }
  .hbmon-responsive-table .tg-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 6px;
  }
  .hbmon-responsive-table .tg-actions::before {
    margin-right: auto;
  }
  .tg-login {
    display: block;
    width: 100%;
  }
  .tg-login table,
  .tg-login tbody,
  .tg-login tr,
  .tg-login td {
    display: block;
    width: 100%;
    box-sizing: border-box;
  }
  .tg-login td {
    padding: 4px 0;
  }
  .tg-login input[type=text],
  .tg-login input[type=password],
  .tg-form input[type=text],
  .tg-form input[type=number],
  .tg-api input[type=text] {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    font-size: 16px;
  }
  .tg-form {
    display: grid;
    gap: 8px;
    width: 100%;
  }
  .tg-form .button {
    min-height: 44px;
  }
  .tg-login .button,
  .tg-logout .button {
    min-height: 44px;
    box-sizing: border-box;
  }
  .tg-actions .button,
  .tg-api .button {
    min-height: 44px;
    box-sizing: border-box;
  }
  .tg-api {
    width: 100%;
    max-width: none;
  }
  .tg-api-actions,
  .tg-download-actions {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 6px;
    margin-top: 6px;
  }
  .tg-api-actions .button,
  .tg-download-actions .button {
    margin: 0;
  }
  pre#log {
    height: min(56dvh, 36em) !important;
    max-width: 100%;
    box-sizing: border-box;
    font-size: 12px !important;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
  }
  .hbmon-system-info p {
    overflow-wrap: anywhere;
  }
}

@media (max-width: 479px) {
  .hbmon-nav-links {
    grid-template-columns: 1fr;
  }
  .hbmon-responsive-table td,
  .hbmon-slot-row {
    grid-template-columns: 84px minmax(0, 1fr);
  }
  .tg-api-actions,
  .tg-download-actions {
    grid-template-columns: 1fr;
  }
}

@media (prefers-reduced-motion: reduce) {
  .hbmon-nav-links {
    transition: none;
  }
}

