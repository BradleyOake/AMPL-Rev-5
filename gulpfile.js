/*------------------------------------------------------
|   gulpfile.js
|-------------------------------------------------------
|
|   Combines all CSS and Javascript files
|
|
|-----------------------------------------------------*/


var elixir = require('laravel-elixir');

elixir(function (mix) {

    // copy fonts for font-awesome and bootstrap
    mix.copy([
            "./resources/assets/bower/font-awesome/fonts",
            "./resources/assets/bower/bootstrapfonts"
    ], 'public/fonts')

   // mix.copy('./resources/assets/js/page-specific', 'public/js')

    // Generate ampl main css
    .less(["*.less"], './resources/assets/css/ampl.css')

    // Main style sheets
    .styles([
            "./resources/assets/bower/bootstrap/dist/css/bootstrap.css",                    // Bootstrap
            "./resources/assets/bower/bootstrap-social/bootstrap-social.css",               // Bootstrap-Social
            "./resources/assets/bower/font-awesome/css/font-awesome.css",                   // Font-Awesome
            "./resources/assets/bower/wow/css/libs/animate.css",                            // Animate
            "./resources/assets/bower/hover/css/hover.css",                                 // Hover
         "./resources/assets/bower/ihover/src/ihover.css",
            "./resources/assets/bower/bootstrap3-dialog/dist/css/bootstrap-dialog.css",     // Bootstrap-Dialog
            "*.css"             // Custom CSS generated from compiled LESS

    ], 'public/css/main.css')

    // Main javascript
    .scripts([
            "./resources/assets/bower/jquery/dist/jquery.js",                               // JQuery
            "./resources/assets/bower/bootstrap/dist/js/bootstrap.js",                      // Bootstrap
            "./resources/assets/bower/angular/angular.js",                                  // Angular
          //"./resources/assets/bower/tg-angular-validator/dist/angular-validator.js",                                  // Angular Validation
            "./resources/assets/bower/angular-animate/angular-animate.js",                  // Angular-Animate
            // "./resources/assets/bower/angular-messages/angular-messages.js",               // Angular-Messages
            "./resources/assets/bower/wow/dist/wow.js",                                     // Wow
            "./resources/assets/bower/jquery.easing/js/jquery.easing.js",                   // JQuery-Easing
            "./resources/assets/bower/bootstrap3-dialog/dist/js/bootstrap-dialog.js",       // Bootstrap-Dialog
            "angular/*.js",     // AMPL Angular main app
            "angular/*/*.js",   // AMPL Angular subfolders
            "main/*.js",        // AMPL Javascript

    ], 'public/js/main.js')

    // Authentication javascript
    .scripts([
            "authentication/*.js"
    ], 'public/js/authentication.js');

});
