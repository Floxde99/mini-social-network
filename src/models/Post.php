<?php

class Post {
    private $idpost;
    private $titre;
    private $contenu;
    private $date_crea;
    private $date_modif;
    private $auteur;

    // Getters
    public function getIdPost() {
        return $this->idpost;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getDateCrea() {
        return $this->date_crea;
    }

    public function getDateModif() {
        return $this->date_modif;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    // Setters
    public function setIdPost($idpost) {
        $this->idpost = $idpost;
        return $this;
    }

    public function setTitre($titre) {
        $this->titre = htmlspecialchars(trim($titre));
        return $this;
    }

    public function setContenu($contenu) {
        $this->contenu = htmlspecialchars(trim($contenu));
        return $this;
    }

    public function setDateCrea($date_crea) {
        $this->date_crea = $date_crea;
        return $this;
    }

    public function setDateModif($date_modif) {
        $this->date_modif = $date_modif;
        return $this;
    }

    public function setAuteur($auteur) {
        $this->auteur = $auteur;
        return $this;
    }

    // Méthodes utilitaires
    public function toArray() {
        return [
            'idpost' => $this->idpost,
            'titre' => $this->titre,
            'contenu' => $this->contenu,
            'date_crea' => $this->date_crea,
            'date_modif' => $this->date_modif,
            'auteur' => $this->auteur
        ];
    }

    public static function fromArray($data) {
        $post = new self();
        $post->setIdPost($data['idpost'] ?? null)
             ->setTitre($data['titre'] ?? '')
             ->setContenu($data['contenu'] ?? '')
             ->setDateCrea($data['date_crea'] ?? null)
             ->setDateModif($data['date_modif'] ?? null)
             ->setAuteur($data['auteur'] ?? null);
        return $post;
    }

    // Méthodes de validation
    public function isValid() {
        return !empty($this->titre) 
            && !empty($this->contenu) 
            && !empty($this->auteur);
    }

    // Méthodes de formatage
    public function getFormattedDateCrea() {
        if ($this->date_crea) {
            $date = new DateTime($this->date_crea);
            return $date->format('d/m/Y à H:i');
        }
        return '';
    }

    public function getFormattedDateModif() {
        if ($this->date_modif) {
            $date = new DateTime($this->date_modif);
            return $date->format('d/m/Y à H:i');
        }
        return '';
    }

    public function getExcerpt($length = 150) {
        if (strlen($this->contenu) <= $length) {
            return $this->contenu;
        }
        return substr($this->contenu, 0, $length) . '...';
    }
}