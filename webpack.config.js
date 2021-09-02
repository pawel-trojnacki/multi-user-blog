const path = require("path");
const MiniCSSExtractPlugin = require("mini-css-extract-plugin");
const UglifyJs = require("uglifyjs-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const JS_DIR = path.resolve(__dirname, "public/assets/javascript");
const OUTPUT_DIR = path.resolve(__dirname, "public/build");

const entry = {
  main: JS_DIR + "/index.js",
};

const output = {
  path: OUTPUT_DIR,
  filename: "javascript/index.js",
};

const plugins = () => [
  new MiniCSSExtractPlugin({
    filename: "css/index.css",
  }),
];

module.exports = (_, argv) => ({
  entry,
  devtool: "source-map",
  module: {
    rules: [
      {
        test: /\.js$/,
        include: [JS_DIR],
        exclude: /node_modules/,
        use: "babel-loader",
      },
      {
        test: /\.(scss)$/,
        use: [MiniCSSExtractPlugin.loader, "css-loader", "sass-loader"],
      },
    ],
  },
  output,
  optimization: {
    minimizer: [
      new CssMinimizerPlugin(),
      new UglifyJs({
        cache: false,
        parallel: true,
        sourceMap: false,
      }),
    ],
  },
  plugins: plugins(argv),
});
