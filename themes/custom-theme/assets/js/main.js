/////////////////////////////////////////////////////////////////////
var $ = jQuery = require("jquery");
var fastClick = require("fastClick");
var tools = require("./libs/tools");
var moment = require("moment");
var bootstrap = require("bootstrap");

/////////////////////////////////////////////////////////////////////
$(function() {
    fastClick(document.body);
    console.log("ok");
});

console.log(moment().format("MMMM Do YYYY, h:mm:ss a"));