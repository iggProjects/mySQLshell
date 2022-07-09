/*
    How to know what type of object is a particular object
    https://stackoverflow.com/questions/7893776/the-most-accurate-way-to-check-js-objects-type

    https://www.w3schools.com/js/js_json_intro.asp 
        JSON stands for JavaScript Object Notation
        JSON is a text format for storing and transporting data
        JSON is "self-describing" and easy to understand

        JSON defines only two data structures: objects and arrays. 
        An object is a set of name-value pairs, and an array is a list of values. 
        JSON defines seven value types: string, number, object, array, true, 
        false, and null. The following example shows JSON data for a sample 
        object that contains name-value pairs.


*/

/* ----------------------------------------------------------*/
var typeObject1 = (function(global) {
    var cache = {};
    return function(obj) {
        var key;
        return obj === null ? 'null' // null
            : obj === global ? 'global' // window in browser or global in nodejs
            : (key = typeof obj) !== 'object' ? key // basic: string, boolean, number, undefined, function
            : obj.nodeType ? 'object' // DOM element
            : cache[key = ({}).toString.call(obj)] // cached. date, regexp, error, object, array, math
            || (cache[key] = key.slice(8, -1).toLowerCase()); // get XXXX from [object XXXX], and cache it
    };
}(this));
    /*
    typeObjectfunction(){}); // -> "function"
    typeObject[1, 2, 3]); // -> "array"
    typeObjectnew Date()); // -> "date"
    typeObject{}); // -> "object"
    */

/* ----------------------------------------------------------*/
var typeObject2 = {
    'get': function(prop) {
       return Object.prototype.toString.call(prop);
    },
    'null': '[object Null]',
    'object': '[object Object]',
    'array': '[object Array]',
    'string': '[object String]',
    'boolean': '[object Boolean]',
    'number': '[object Number]',
    'date': '[object Date]',
 }
    /* Example
    if(typeObject2.get(prop) == typeObject2.number) {

    }
    */

/* ----------------------------------------------------------*/    

var obj = "someObject";
var proto =  Object.getPrototypeOf(obj);
proto === "type".prototype; // true or false
/*
obj = "some string";
    Example: proto === String.prototype; // true
*/


/* ----------------------------------------------------------*/    
var string1 = "Test";
//console.log(string1.__proto__.constructor.name);
var array1 = [];
// console.log(array1.__proto__.constructor.name);

/*
var a = 1 
var b = null;
c = [a, b];
console.log('c es: ' + c.toString());
*/

/* ----------------------------------------------------------*/    
function getRealObjectType(obj) {
    return Object.prototype.toString.call(obj).match(/\[\w+ (\w+)\]/)[1].toLowerCase();
}
