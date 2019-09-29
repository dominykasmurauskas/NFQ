# NFQ akademijos atrankos Back-end užduotis

Ligoninėse, bankuose, pašte, pasų išdavimo skyriuose ir pan. galima matyti ekranus su skaičiukais. Atėjęs klientas pasirenka paslaugą ir gauna lapuką pas pasirinktą specialistą/darbuotoją/langelį ir laukia savo eilės, kuriai sulaukti ne visada pakanka kantrybės. Šio projekto tikslas yra patobulinti tokią veikimo sistemą nurodant klientui apytikslį laukimo laiką, sudarant specialistų užimtumo statistiką bei suteikiant klientui tokias galimybes kaip pavėlinti ar aplamai atšaukti savo vizitą.


## Pradžia

Šių instrukcijų pagalba galėsite įdiegti sistemą savo kompiuteryje tolesnei plėtrai ar testavimo tikslams. Norint projektą paleisti gyvai, tai bus aprašyta kitame skyriuje. 

### Diegimas

Parsisiųskite projekto vietinę kopiją į savo kompiuterį
```
git clone https://github.com/dominykasmurauskas/NFQ.git
```

Atsidarykite projekto aplanką
```
cd NFQ
```

Composer pagalba įdiekite projekto priklausomybes
```
composer install
```

Nukopijuokite pavyzdinį konfigūracijos failą ir jame užpildykite duomenis
```
cp .env.example .env
```

Sugeneruokite naują programos raktą
```
php artisan key:generate
```

Paruoškite duomenų bazę (prieš tai įsitikinkite, kad konfigūracijos failas teisingai užpildytas)
```
php artisan migrate
```

Paleiskite vietinį serverį
```
php artisan serve
```

Jei nenurodyta kitaip, virtualus serveris bus pasiekiamas šiuo adresu: http://localhost:8000

## Programos testavimas

Norint ištestuoti gyvai paleistą versiją, galite susikurti naują specialistą atidarę /register URL. Specialistas bus sukurtas pirmai paslaugai. Jeigu norite pakeisti paslaugą, kurią teikia specialistas, tai padaryti galima kolkas tik rankiniu būdu pakeitus duomenų bazės įrašą.

Keli testiniai prisijungimai:
Email: admin@admin.com
Password: Admin123
Paslauga: 1

Email: admin2@admin.com
Password: Admin123
Paslauga: 2

Email: admin3@admin.com
Password: Admin123
Paslauga: 5

Programoje yra panaudoti PHPUnit testai. Juos visus galite paleisti pasinaudoję šia komanda:
```
php vendor/phpunit/phpunit/phpunit
```

###### Svarbu: phpunit.xml faile yra nurodyta, kad testavimai paleidžiami ne pagal numatytąjį 'Test.php' suffix'a, bet pagal 'Tests.php'. Taip pat norint paleisti testavimą nebūtina migruoti duomenų bazės - PHPUnit testai vykdomi atmintyje.

## Technologijos

* [Laravel](https://laravel.com/docs/5.7/installation) - Back-end PHP karkasas
* [Bootstrap 4.3.1](https://getbootstrap.com/) - Front-end CSS & JS karkasas

## NFQ back-end užduoties reikalavimų nuorodos
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

## Licencija

MIT
