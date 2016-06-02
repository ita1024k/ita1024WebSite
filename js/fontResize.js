var fontResize = function (config) {
    this.default ={
        width:640
    };
    this.config = !config?this.default :config;
};

fontResize.prototype.setBody = function (width) {
    var sW = width||document.body.clientWidth;
    var htmlW = (sW/this.config.width * 62.5)+"%";
    var _h = document.querySelector("html");
    _h.style.fontSize = htmlW;
};
fontResize.prototype.init = function (width) {
    var _self = this;
    _self.setBody(width);
    window.onresize = function () {
        _self.setBody(width);
    }
};