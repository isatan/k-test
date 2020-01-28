'use strict';


/**
 * サーバ上にある画像へのPathを与えると、AI で分析し、その画像が所属する Class を返却する API があると します
 *
 * image_path String サーバ上にある画像ファイルPath
 * returns Success
 **/
exports.rootPOST = function(image_path) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
  "success" : true,
  "estimated_data" : {
    "confidence" : 0.8683,
    "class" : 3
  },
  "message" : "success"
};
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}

