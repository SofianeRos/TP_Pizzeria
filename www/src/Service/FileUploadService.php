<?php

namespace App\Service;

class FileUploadService
{
    /**
     * Gère l'upload d'un fichier image
     * * @param array $file Le fichier reçu via $_FILES['image']
     * @param string $targetDir Le dossier de destination
     * @return string Le nom du fichier final
     */
    public function upload(array $file, string $targetDir = 'uploads'): string
    {
        // On crée le dossier s'il n'existe pas
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // On génère un nom unique pour éviter d'écraser les fichiers
        // ex: pizza_123456789.jpg
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'pizza_' . uniqid() . '.' . $extension;
        
        // On déplace le fichier
        $destination = rtrim($targetDir, '/') . '/' . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $fileName;
        }
        
        throw new \RuntimeException("Erreur lors de l'upload de l'image.");
    }
}