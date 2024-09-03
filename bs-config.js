module.exports = {
    proxy: 'http://shirakalu.test',  // Replace with your Yii2 app URL
    files: [
        'web/css/*.css',  // Path to CSS files to watch for changes
        'web/js/*.js',    // Path to JS files to watch for changes
        'views/**/*.php', // Path to your view files to watch for changes
        'themes/**/*.php', // Path to your view files to watch for changes
        'controllers/**/*.php',
        'models/**/*.php',
        'index.php'
    ],
    notify: false, // Set to true if you want to see BrowserSync notifications
    open: true    // automatically open the browser
};
