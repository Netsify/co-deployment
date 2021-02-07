var routes = require('./routes.json');

export default function () {
    var args = Array.prototype.slice.call(arguments);
    // console.log(args);
    var name = args.shift();
    // console.log(routes[name].matchAll('/\{.{1,}\}/'));
    // console.log(args[1]);

    if (routes[name] === undefined) {
        console.log('Undefined route name');
    } else {
        return '/' + routes[name].split('/').map(str => str[0] == '{' ? args.shift() : str).join('/');
    }
}