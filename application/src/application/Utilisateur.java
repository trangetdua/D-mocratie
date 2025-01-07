package application;

import java.util.List;

public class Utilisateur {
    private int id;
    private String nom;

    public Utilisateur(int id, String nom) {
        this.id = id;
        this.nom = nom;
    }

    public int getId() {
        return id;
    }

    public String getNom() {
        return nom;
    }

    @Override
    public String toString() {
        return "Utilisateur{id=" + id + ", nom='" + nom + "'}";
    }
}
