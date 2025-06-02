export const server = (done) => {
    app.plugins.browsersync.init({
        proxy: "http://wordpress-sme/",
        notify: false,
        port: 3000,
    });
    done();
};
