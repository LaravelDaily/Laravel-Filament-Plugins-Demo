Šitam pirmiausia geriausia susikurti resources kokių reikia, tada instaliuoti package ir leisti `artisan shield:install`.

Taip sukurs visus policy tiems resource. Padariau čia paprastą User resource, kad patogu būtų sukurti useri ir jam duoti rolę.

Pvz. prie post paprastam gali nuimti viską delete ir tik admin galės trinti.

Jeigu eigoje prireikia naujų resource tai paleidus `shield:generate` sukurs policies per naują. Arba su [opcijom](https://github.com/bezhanSalleh/filament-shield#shieldgenerate) kurti tik ką reikia.

Pabaigus galima susigeneruoti seedus `shield:seeder`