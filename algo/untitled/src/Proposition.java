import java.util.ArrayList;
import java.util.List;

public class Proposition {
    private int id;
    private String titre;
    private float evaluationBudgetaire;
    private int voteCount;
    private List<Utilisateur> votePour; // Danh sách người dùng bầu chọn
    private List<Utilisateur> voteTotal;
    Thematique thematique;

    public Thematique getThematique() {
        return thematique;
    }

    public void setThematique(Thematique thematique) {
        this.thematique = thematique;
    }

    // Constructor
    public Proposition(int id, String titre, float evaluationBudgetaire) {
        this.id = id;
        this.titre = titre;
        this.evaluationBudgetaire = evaluationBudgetaire;
        this.voteCount = 0;
        this.votePour = new ArrayList<>();
    }

    // Getter và Setter
    public int getId() {
        return id;
    }

    public String getTitre() {
        return titre;
    }

    public float getEvaluationBudgetaire() {
        return evaluationBudgetaire;
    }

    public int getVoteCount() {
        return voteCount;
    }

    public void setVoteCount(int voteCount) {
        this.voteCount = voteCount;
    }
    public void setVotePour(List<Utilisateur> votePour) {
        this.votePour = votePour;
    }

    public List<Utilisateur> getVoteTotal() {
        return voteTotal;
    }

    public void setVoteTotal(List<Utilisateur> voteTotal) {
        this.voteTotal = voteTotal;
    }

    public List<Utilisateur> getVotePour() {
        return votePour;
    }


    @Override
    public String toString() {
        return "Proposition{id=" + id + ", titre='" + titre + "', evaluationBudgetaire=" + evaluationBudgetaire + ", voteCount=" + voteCount + '}';
    }
}
