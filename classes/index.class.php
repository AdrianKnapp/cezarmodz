<?php
require __DIR__.'/../config.php';


class Query {
    private $pdo;
    private $buscarAnuncios;

    public function __construct($pdo) {
        $this->pdo = $pdo;
      }
    
    public function queryDefault() {
        $buscarAnuncios = "
            SELECT
            pt.id_produto,
            pt.nome,
            pt.plataforma,
            pt.valor,
            pt.tipo,
            pt.img_address,
            pf.id_plataforma,
            pf.nome_plat
            FROM produtos AS pt
            INNER JOIN plataformas AS pf
            ON pt.plataforma = pf.id_plataforma
            WHERE pt.disponibilidade = 0
        ";
        $buscarAnuncios = $this->pdo->query($buscarAnuncios);
        if($buscarAnuncios->rowCount() > 0){
            $this->buscarAnuncios = $buscarAnuncios;
            return $this->buscarAnuncios;
            return true;
        } else {
            return false;
        }
    }

    public function queryFilter($structure) {
        $buscarAnuncios = "
            SELECT
            pt.id_produto,
            pt.nome,
            pt.plataforma,
            pt.valor,
            pt.tipo,
            pt.disponibilidade,
            pt.img_address,
            pf.id_plataforma,
            pf.nome_plat
            FROM produtos AS pt
            INNER JOIN plataformas AS pf
            ON pt.plataforma = pf.id_plataforma
            $structure
        ";
        /* print_r($buscarAnuncios); */
        $buscarAnuncios = $this->pdo->query($buscarAnuncios);
        if($buscarAnuncios->rowCount() > 0){
            $this->buscarAnuncios = $buscarAnuncios;
            return $this->buscarAnuncios;
            return true;
        } else {
            return false;
        }
    }

}












?>