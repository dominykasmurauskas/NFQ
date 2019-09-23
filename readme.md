# NFQ akademijos atrankos Back-end užduotis

Ligoninese, bankuose, pašte, pasu išdavimo skyriuose ir pan. galima matyti ekranus su skaiciukais. Atejes klientas pasirenka paslauga ir gauna lapuka pas pasirinkta specialista/darbuotoja/langeli ir laukia savo eiles, kuriai sulaukti ne visada pakanka kantrybes. Šio projekto tikslas yra patobulinti tokia veikimo sistema nurodant klientui apytiksli laukimo laika, sudarant specialistu užimtumo statistika bei suteikiant klientui tokias galimybes kaip pavelinti ar aplamai atšaukti savo vizita.


## Pradžia

Šiu instrukciju pagalba galesite idiegti sistema savo kompiuteryje tolesnei pletrai ar testavimo tikslams. Norint projekta paleisti gyvai, tai bus aprašyta kitame skyriuje. 

### Diegimas

Parsisiuskite projekto vietine kopija i savo kompiuteri
```
git clone https://github.com/dominykasmurauskas/NFQ.git
```

Atsidarykite projekto aplanka
```
cd NFQ
```

Composer pagalba idiekite projekto priklausomybes
```
composer install
```

Nukopijuokite pavyzdini konfiguracijos faila ir jame užpildykite duomenis
```
cp .env.example .env
```

Sugeneruokite nauja programos rakta
```
php artisan key:generate
```

Paruoškite duomenu baze (prieš tai isitikinkite, kad konfiguracijos failas teisingai užpildytas)
```
php artisan migrate
```

Paleiskite vietini serveri
```
php artisan serve
```

Jei nenurodyta kitaip, virtualus serveris bus pasiekiamas šiuo adresu: http://localhost:8000

## Programos testavimas

Programoje yra panaudoti PHPUnit testai. Juos visus galite paleisti pasinaudoje šia komanda:
```
php vendor/phpunit/phpunit/phpunit
```

###### Svarbu: phpunit.xml faile yra nurodyta, kad testavimai paleidžiami ne pagal numatytaji 'Test.php' suffix'a, bet pagal 'Tests.php'. Taip pat norint paleisti testavima nebutina migruoti duomenu bazes - PHPUnit testai vykdomi atmintyje.

## Technologijos

* [Laravel](https://laravel.com/docs/5.7/installation) - Back-end PHP karkasas
* [Bootstrap 4.3.1](https://getbootstrap.com/) - Front-end CSS & JS karkasas

## NFQ back-end užduoties reikalavimu nuorodos
Žr. cia: [NFQ back-end užduoties reikalavimu igyvendinimo nuorodos](https://gist.github.com/dominykasmurauskas/1533064c447caf655eed16e7ed1b93fb)

## Žinomos klaidos
Nera

## Autoriai

* **Dominykas Murauskas** - [LinkedIN](https://www.linkedin.com/in/dominykas-murauskas/)

## Galerija

<img src="https://dominykasmurauskas.lt/githubImages/Svieslente.png" alt="Svieslente" width="200"/> <img src="https://dominykasmurauskas.lt/githubImages/specialistas.png" alt="Specialisto puslapis" width="200" />
<img src="https://dominykasmurauskas.lt/githubImages/klientas.png" alt="Kliento puslapis" width="200" />
<img src="https://dominykasmurauskas.lt/githubImages/statistika1.png" alt="Statistika 1" width="200" />
<img src="https://dominykasmurauskas.lt/githubImages/statistika2.png" alt="Statistika 2" width="200" />
<img src="https://dominykasmurauskas.lt/githubImages/mail.png" alt="Mail notification" width="200"/>

## Licenzija

MIT
