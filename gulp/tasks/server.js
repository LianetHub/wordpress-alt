export const server = (done) => {
    app.plugins.browsersync.init({
        server: {
            baseDir: `${app.path.build.html}`
        },
        // proxy: "localhost:3000",
        notify: false,
        port: 3000,
    });
    // done();
};
