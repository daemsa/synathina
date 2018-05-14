# Synathina

Synathina Joomla project

### Prerequisites
You will need to have [npm](https://www.npmjs.com) and [node.js](https://nodejs.org) installed on your machine


### Run
```
cd templates/synathina
npm install
```
(this might take a little while on the 1st run since it will take care of all the dependencies for you)

### For Development
```
npm run watch
```

### For Production
```
npm run build
```

### Troubleshooting

#### errors with EPIPE
In order to make a web pack bundle on Linux, you need to install `libpng16-dev` (`sudo apt-get install libpng16-dev`).

