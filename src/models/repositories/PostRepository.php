<?php

class PostRepository extends Db {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function findAll() {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username 
            FROM post p
            JOIN users u ON p.auteur = u.iduseur
            ORDER BY p.date_crea DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($idpost) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username 
            FROM post p
            JOIN users u ON p.auteur = u.iduseur
            WHERE p.idpost = ?
        ");
        $stmt->execute([$idpost]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByAuteur($auteur) {
        $stmt = $this->db->prepare("
            SELECT * FROM post 
            WHERE auteur = ?
            ORDER BY date_crea DESC
        ");
        $stmt->execute([$auteur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($titre, $contenu, $auteur) {
        $stmt = $this->db->prepare("
            INSERT INTO post (titre, contenu, auteur, date_crea) 
            VALUES (?, ?, ?, NOW())
        ");
        if (!$stmt->execute([$titre, $contenu, $auteur])) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur SQL : " . $errorInfo[2]);
        }
        return true;
    }

    public function update($idpost, $titre, $contenu, $auteur) {
        $stmt = $this->db->prepare("
            UPDATE post 
            SET titre = ?, 
                contenu = ?, 
                date_modif = NOW()
            WHERE idpost = ? AND auteur = ?
        ");
        return $stmt->execute([$titre, $contenu, $idpost, $auteur]);
    }

    public function delete($idpost, $auteur) {
        $stmt = $this->db->prepare("
            DELETE FROM post 
            WHERE idpost = ? AND auteur = ?
        ");
        return $stmt->execute([$idpost, $auteur]);
    }

    public function isOwner($idpost, $auteur) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM post 
            WHERE idpost = ? AND auteur = ?
        ");
        $stmt->execute([$idpost, $auteur]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function formatPost($post) {
        return [
            'id' => $post['idpost'], // Changé de 'idpost' à 'id' pour la vue
            'title' => $post['titre'], // Changé de 'titre' à 'title' pour la vue
            'content' => $post['contenu'], // Changé de 'contenu' à 'content' pour la vue
            'created_at' => new DateTime($post['date_crea']),
            'updated_at' => $post['date_modif'] ? new DateTime($post['date_modif']) : null,
            'author' => [ // Changé de 'auteur' à 'author' pour la vue
                'id' => $post['auteur'],
                'username' => $post['username']
            ]
        ];
    }
}