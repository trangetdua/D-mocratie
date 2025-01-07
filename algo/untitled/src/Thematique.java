import java.util.ArrayList;

public class Thematique {
    float budget;
    public float getBudget() {
        return budget;
    }
    public void setBudget(float budget) {
        this.budget = budget;
    }
    public String getNom() {
        return nom;
    }
    public void setNom(String nom) {
        this.nom = nom;
    }
    public ArrayList<Proposition> getSesPropositions() {
        return sesPropositions;
    }
    public void setSesPropositions(ArrayList<Proposition> sesPropositions) {
        this.sesPropositions = sesPropositions;
    }
    String nom;
    ArrayList<Proposition> sesPropositions;
}
