<?php

class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pwd = DB_PWD;
    private $name = DB_NAME;

    private $dbh;
    private $stmt;

    //pertama kali instance class database, fungsi koneksi ke database akan langsung dijalankan
    public function __construct(){
        //memberi tahu database apa yang diguakan, hostamenya, dan nama database nya. dsn = data source name
        $dsn = "mysql:host={$this->host};dbname={$this->name}";
        
        //parameter untuk optimasi koneksi ke database
        $option = [
            PDO::ATTR_PERSISTENT => true,                   //agar koneksi ke database tidak terputus sebelum diputus
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION      //jika error, tampilkan pesan error exceptionnya
        ];

        //coba koneksi ke database
        try{
            $this->dbh = new PDO(                           //buat koneksi baru (instansi objek PDO)
                $dsn,                                       //kasih tau sumber datanya darimana
                $this->user,                                //masuk ke db sebagai siapa
                $this->pwd,                                 //password db untuk user tersebut
                $option                                     //pengaturan untuk optimasi database
            );
        }catch(PDOException $e){                            //jika error, $e menampung objek exception
            die($e->getMessage());                          //jika error, hentikan script, lalu ambil pesannya, dan tampilkan
        }
    }

    //untuk menyiapkan query/statement yang akan dijalankan ke database
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    //membinding data jika diperlukan beberapa value untuk menjalankan query, menghindari sql injection
    public function bind($parameter, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($parameter, $value, $type);
    }

    public function execute(){
        $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function singleResult(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}