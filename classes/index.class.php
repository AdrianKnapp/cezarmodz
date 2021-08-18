<?php
require __DIR__.'/../config.php';


class Query {
    private $pdo;
    private $buscarAnuncios;
    private $linesToQuery;
    public function __construct($pdo, $linesToQuery) {
        $this->pdo = $pdo;
        $this->linesToQuery = $linesToQuery;
    }
    public function queryToCountDbDataLines($structure) {
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
            $structure
        ";
        $buscarAnuncios = $this->pdo->query($buscarAnuncios);
        if($buscarAnuncios->rowCount() > 0){
            $numTotalLinhas = $buscarAnuncios->rowCount();
            return $numTotalLinhas;
        } else {
            return false;
        }
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
            ORDER BY  pt.valor ASC
            LIMIT 10 OFFSET $this->linesToQuery;
        ";
        $buscarAnuncios = $this->pdo->query($buscarAnuncios);
       
        if($buscarAnuncios->rowCount() > 0){
            $this->buscarAnuncios = $buscarAnuncios;
            return  $this->buscarAnuncios;
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
            LIMIT 10 OFFSET $this->linesToQuery;
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

}












?>