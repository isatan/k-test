'use strict';

var utils = require('../utils/writer.js');
var API = require('../service/APIService');

module.exports.rootPOST = function rootPOST (req, res, next) {
  var image_path = req.swagger.params['image_path'].value;
  API.rootPOST(image_path)
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
