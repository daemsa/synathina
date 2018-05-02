
const path = require('path');

const config = {
    entry: {
        app: './templates/synathina/js/app/app.js'
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'app.bundle.js'
    }
};

module.exports = config;