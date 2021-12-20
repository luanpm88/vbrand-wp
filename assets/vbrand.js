var vBrand = {
    loadCss: function(url) {
        if (this.css == null) {
            var head  = document.getElementsByTagName('head')[0];
            var link  = document.createElement('link');
            link.rel  = 'stylesheet';
            link.type = 'text/css';
            link.href = url;
            link.media = 'all';
            head.appendChild(link);

            this.css = link;
        }
    },

    loadJs: function(jss, callback) {
        var _this = this;

        if (jss.length > 0) {
            var s = document.createElement("script");
            var url = jss.shift();

            console.log("loading: " + url);

            s.type = "text/javascript";
            s.src = url;
            s.setAttribute('builder-helper', 'true')
            s.onload = function () {
                //
                _this.loadJs(jss, callback);
            };
            window.document.head.appendChild(s);
        } else {
            if (typeof(callback) !== 'undefined') {
                callback();
            }
        }
    },

    autoHeight: function() {
        var body = document.body,
            html = document.documentElement;
        var height = Math.max( body.scrollHeight, body.offsetHeight, 
                                html.clientHeight, html.scrollHeight, html.offsetHeight );

        parent.postMessage({
            height: height
        }, "*");
    }
}

if (parent.length) {
    // include vband.css
    vBrand.loadCss('/wp-content/plugins/vbrand-wp/assets/vbrand.css');

    // // auto height
    // setInterval(() => {
    //     vBrand.autoHeight();
    // }, 500);
}

// message from parent
window.addEventListener("message", (event) => {
    dark_mode = event.data.dark_mode;

    if (dark_mode) {
        var element = document.getElementsByTagName("body")[0];
        element.classList.add("mode-dark");
    }
});