<?php

namespace App\DataFixtures\Provider;

class AppProvider
{
    private $user = [
        "admin" => [
            "email" => "admin@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "admin"
        ],
        "user" => [
            "email" => "user@oclock.io",
            "roles" => [],
            "password" => "user"
        ],
        "nicolas" => [
            "email" => "nicolas@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "nicolas"
        ],
        "ben" => [
            "email" => "ben@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "ben"
        ],
        "hocine" => [
            "email" => "hocine@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "hocine"
        ],
        "thanh" => [
            "email" => "thanh@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "thanh"
        ],
    ];

    // private $comicsData = [
    //     "Official Handbook of the Marvel Universe (2004) #13 (TEAMS)",
    //     "MARVEL MASTERWORKS: THE UNCANNY X-MEN VOL. 3 HC (Trade Paperback)",
    //     "Ant-Man (2003) #4",
    //     "Official Handbook of the Marvel Universe (2004) #14 (FANTASTIC FOUR)",
    //     "Kabuki Reflections Vol. 1 (Hardcover)",
    //     "Official Handbook of the Marvel Universe (2004) #9 (THE WOMEN OF MARVEL)",
    //     "Storm (2006)",
    //     "The Stand: American Nightmares HC (Hardcover)",
    //     "Ant-Man (2003) #2",
    //     "Official Handbook of the Marvel Universe (2004) #11 (X-MEN - AGE OF APOCALYPSE)",
    //     "Marvel Previews (2017)",
    //     "Punishermax: Kingpin (2010)",
    //     "Marvel Adventures Super Heroes Special (2010) #1",
    //     "Ant-Man (2003) #3",
    //     "Official Handbook of the Marvel Universe (2004) #10 (MARVEL KNIGHTS)",
    //     "Magician: Apprentice Riftwar Saga (2010) #13",
    //     "Ultimate Spider-Man (2000) #110 (Mark Bagley Variant)",
    //     "ULTIMATE X-MEN VOL. 5: ULTIMATE WAR TPB (Trade Paperback)",
    //     "Marvel Age Spider-Man Vol. 2: Everyday Hero (Digest)",
    //     "Marvels Vol. 1 (1994) #7",
    //     "X-Men: Phoenix - Warsong (2006)",
    //     "Wolverine Saga (2009) #7",
    //     "Official Handbook of the Marvel Universe (2004) #12 (SPIDER-MAN)",
    //     "Halo Chronicles (2009) #1",
    //     "Marvel Previews (2017)",
    //     "Marvels Vol. 1 (1994) #1",
    //     "Holiday Special (1969) #1",
    //     "Civil War (Hardcover)",
    //     "Marvels Vol. 1 (1994) #8",
    //     "Amazing Spider-Man 500 Covers Slipcase - Book II (Trade Paperback)",
    //     "Penance: Relentless (2008)",
    //     "Marvels Vol. 1 (1994) #3",
    //     "Gun Theory (2003) #3",
    //     "Official Marvel Universe Handbook (2009) #2",
    //     "Sentry, the (Trade Paperback)",
    //     "Ant-Man (2003) #1",
    //     "X-Men: Days of Future Past (Trade Paperback)"
    // ];

    // private $comicsPosterData = [
    //     "http://i.annihil.us/u/prod/marvel/i/mg/f/20/4bc63a47b8dcb.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/10/4bb3c93c1725d.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/4/20/4bc697c680890.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/90/4bc6353e5fc56.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/e/e0/4bac3ad5d17c7.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/b0/4c7d666c0e58a.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/c/80/4bc5fe7a308d7.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/a/10/4bb59859e2e3e.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/f/20/4bc69f33cafc0.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/30/4bc6494ed6eb4.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/c/80/5e3d7536c8ada.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/5/90/4c4e014aa3086.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/d/70/4bc69c7e9b9d7.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/30/4bc64df4105b9.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/c/b0/4bc6670c80007.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/20/4bc665483c3aa.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/c/e0/4bc4947ea8f4d.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/2/f0/4bc6650c80007.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/6/50/4c3645d0d29e3.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/b/40/4bc64020a4ccc.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/f/c0/4bc66d78f1bee.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/6/e0/4bc6a2497684e.jpg",
    //     "http://i.annihil.us/u/prod/marvel/i/mg/9/d0/58b5cfb6d5239.jpg"
    // ];

    private $comicsInfos = [
        [
            "title" => "Official Handbook of the Marvel Universe (2004) #13 (TEAMS)",
            "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/f/20/4bc63a47b8dcb.jpg"
        ],
        [
        "title" => "MARVEL MASTERWORKS: THE UNCANNY X-MEN VOL. 3 HC (Trade Paperback)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/10/4bb3c93c1725d.jpg"
        ],
        [
        "title" => "Ant-Man (2003) #4",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/4/20/4bc697c680890.jpg"
        ],
        [
        "title" => "Official Handbook of the Marvel Universe (2004) #14 (FANTASTIC FOUR)",
        "poster"=> "http://i.annihil.us/u/prod/marvel/i/mg/9/90/4bc6353e5fc56.jpg"
        ],
        [
        "title" => "Kabuki Reflections Vol. 1 (Hardcover)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/e/e0/4bac3ad5d17c7.jpg"
        ],
        [
        "title" => "Official Handbook of the Marvel Universe (2004) #9 (THE WOMEN OF MARVEL)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/b0/4c7d666c0e58a.jpg"
        ],
        [
        "title" => "Storm (2006)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/80/4bc5fe7a308d7.jpg"
        ],
        [
        "title" => "The Stand: American Nightmares HC (Hardcover)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/a/10/4bb59859e2e3e.jpg"
        ],
        [
        "title" => "Ant-Man (2003) #2",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/f/20/4bc69f33cafc0.jpg"
        ],
        [
        "title" => "Official Handbook of the Marvel Universe (2004) #11 (X-MEN - AGE OF APOCALYPSE)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/b0/4bc6494ed6eb4.jpg"
        ],
        [
        "title" => "Marvel Previews (2017)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/80/5e3d7536c8ada.jpg"
        ],
        [
        "title" => "Punishermax: Kingpin (2010)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/5/90/4c4e014aa3086.jpg"
        ],
        [
        "title" => "Ant-Man (2003) #3",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/d/70/4bc69c7e9b9d7.jpg"
        ],
        [
        "title" => "Official Handbook of the Marvel Universe (2004) #10 (MARVEL KNIGHTS)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/30/4bc64df4105b9.jpg"
        ],
        [
        "title" => "Ultimate Spider-Man (2000) #110 (Mark Bagley Variant)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/e0/4bc4947ea8f4d.jpg"
        ],
        [
        "title" => "ULTIMATE X-MEN VOL. 5: ULTIMATE WAR TPB (Trade Paperback)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/2/f0/4bc6670c80007.jpg"
        ],
        [
        "title" => "Marvel Age Spider-Man Vol. 2: Everyday Hero (Digest)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/20/4bc665483c3aa.jpg"
        ],
        [
        "title" => "X-Men: Phoenix - Warsong (2006)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/6/50/4c3645d0d29e3.jpg"
        ],
        [
        "title" => "Official Handbook of the Marvel Universe (2004) #12 (SPIDER-MAN)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/b/40/4bc64020a4ccc.jpg"
        ],
        [
        "title" => "Incredible Hulks (2010) #604 (DJURDJEVIC 70TH ANNIVERSARY VARIANT)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/b/d0/4badb223f33c9.jpg"
        ],
        [
        "title" => "Civil War (Hardcover)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/8/c0/51dda501724ed.jpg"
        ],
        [
        "title" => "Ultimate Spider-Man Ultimate Collection Book 1 (Trade Paperback)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/6/c0/59079911f0fdb.jpg"
        ],
        [
        "title" => "Halo Chronicles (2009) #2",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/1/e0/4bb4ecb6aa5a9.jpg"
        ],
        [
        "title" => "Penance: Relentless (2008)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/90/4bb860a46f58d.jpg"
        ],
        [
        "title" => "Gun Theory (2003) #3",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/60/4bc69f11baf75.jpg"
        ],
        [
        "title" => "Gun Theory (2003) #4",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/60/4bc69f11baf75.jpg"
        ],
        [
        "title" => "Hedge Knight II: Sworn Sword (2007) #1 (Yu Variant)",
        "poster"=> "http://i.annihil.us/u/prod/marvel/i/mg/9/50/4bc49463dad62.jpg"
        ],
        [
        "title" => "Sentry, the (Trade Paperback)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/f/c0/4bc66d78f1bee.jpg"
        ],
        [
        "title" => "Ant-Man (2003) #1",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/6/e0/4bc6a2497684e.jpg"
        ],
        [
        "title" => "X-Men: Days of Future Past (Trade Paperback)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/d0/58b5cfb6d5239.jpg"
        ]
    ];
    
    private $charactersData = [
        [
            "name" => "Agent Brand",
            "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/4/60/52695285d6e7e.jpg"
        ],
        [
            "name" => "Absorbing Man",
            "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/1/b0/5269678709fb7.jpg"
        ],
        [
            "name" => "Anita Blake",
            "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/2/a0/4c0038fa14452.jpg"
        ],
        [
        "name" => "Banshee (Theresa Rourke)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/b/c0/4ce5a1a50e56b.jpg"
        ],
        [
        "name" => "3-D Man",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/c/e0/535fecbbb9784.jpg"
        ],
        [
        "name" => "Abyss",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/30/535feab462a64.jpg"
        ],
        [
        "name" => "Adam Warlock",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/a/f0/5202887448860.jpg"
        ],
        [
        "name" => "Amadeus Cho",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/3/80/520288b9cb581.jpg"
        ],
        [
        "name" => "Abyss (Age of Apocalypse)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/3/80/4c00358ec7548.jpg"
        ],
        [
        "name" => "Battering Ram",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/f/60/4c002e0305708.gif"
        ],
        [
        "name" => "Alex Power",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/50/4ce5a385a2e82.jpg"
        ],
        [
        "name" => "Balder",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/b/f0/4ce5a7c2814ba.gif"
        ],
        [
        "name" => "Arcade",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/2/a0/4c0042091ab69.jpg"
        ],
        [
        "name" => "Angel (Ultimate)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/4/50/531769ae4399f.jpg"
        ],
        [
        "name" => "Alex Wilder",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/2/c0/4c00377144d5a.jpg"
        ],
        [
        "name" => "Abomination (Emil Blonsky)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/9/50/4ce18691cbf04.jpg"
        ],
        [
        "name" => "Banshee",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/b/03/52740e4619f54.jpg"
        ],
        [
        "name" => "Ajak",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/2/80/4c002f35c5215.jpg"
        ],
        [
        "name" => "Alicia Masters",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/b/40/4c003d40ac7ae.jpg"
        ],
        [
        "name" => "Aqueduct",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/5/50/4c0035b3630cd.jpg"
        ],
        [
        "name" => "Annihilus",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/5/f0/528d31f20a2f6.jpg"
        ],
        [
        "name" => "A-Bomb (HAS)",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/3/20/5232158de5b16.jpg"
        ],
        [
        "name" => "Alice",
        "poster" => "http://i.annihil.us/u/prod/marvel/i/mg/6/70/4cd061e6d6573.jpg"
        ],
    ];

    // /**
    //  * get a random comics from the provider
    //  * @return string random comics
    //  */
    // public function comics() :string
    // {
    //     return $this->comicsData[array_rand($this->comicsData)];
    // }

    // /**
    //  * get a random comicsPoster from the provider
    //  * @return string random comicsPoster
    //  */
    // public function comicsPoster() :string
    // {
    //     return $this->comicsPosterData[array_rand($this->comicsPosterData)];
    // }

    /**
     * Get an array of random Comics with their poster from the provider
     *
     * @return array random Comics with associated poster
     */
    public function comicsInfos()
    {
        return $this->comicsInfos;
    }

    /**
     * Get an array of random Characters with their poster from the provider
     *
     * @return array of random Characters with associated poster
     */
    public function charactersInfos()
    {
        return $this->charactersData;
    }

    /**
     * Get a a user, available roles : admin, email
     * @param string $role the role of the user
     * @return array a user
     */
    public function user($role = null)
    {
        if ($role) {
            return $this->user[$role];
        }
        return $this->user[array_rand($this->user)];
    }


}