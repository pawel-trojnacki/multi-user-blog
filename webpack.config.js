const path = require("path");

const JS_DIR = path.resolve(__dirname, "public/assets/javascript");
const OUTPUT_DIR = path.resolve(__dirname, "public/build");

const entry = {
  main: JS_DIR + "/index.js",
};

const output = {
  path: OUTPUT_DIR,
  filename: "javascript/index.js",
};

module.exports = {
  entry,
  module: {
    rules: [
      {
        test: /\.js$/,
        include: [JS_DIR],
        exclude: /node_modules/,
        use: "babel-loader",
      },
    ],
  },
  // resolve: {
  //   extensions: ["*", ".js"],
  // },
  output,
};
