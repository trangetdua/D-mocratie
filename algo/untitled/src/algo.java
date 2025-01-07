import java.util.*;
import java.util.Comparator;

public class algo {

    private ArrayList<Thematique> listeThematique(ArrayList<Proposition> listeProp){
        ArrayList<Thematique> listeTheme= new ArrayList<Thematique>();
        for(int i = 0;i<listeProp.size();i++){
            if(!listeTheme.contains(listeProp.get(i).getThematique())){
                listeTheme.add(listeProp.get(i).getThematique());
            }
        }
        return listeTheme;

    }

    private ArrayList<Proposition> triListePropPopularite(ArrayList<Proposition> listeProp){
        ArrayList<Proposition> listeTrie = new ArrayList<>();
        float maxRatio;
        int maxIndex;
        float ratio;
        while(listeProp.size()>0) {
            maxRatio = 0;
            maxIndex =0;
            for(int i = 0;i<listeProp.size();i++) {
                ratio = (float)listeProp.get(i).getVotePour().size() /listeProp.get(i).getVoteTotal().size();
                if(ratio > maxRatio) {
                    maxRatio = ratio;
                    maxIndex =i;
                }
                listeTrie.add(listeProp.get(maxIndex));
                listeProp.remove(maxIndex);
            }
        }
        return listeTrie;



    }
    public ArrayList<Proposition> gloutonThematiquePopularite(ArrayList<Proposition> listeProp) {
        ArrayList<Proposition> listePropApprouve = new ArrayList<Proposition>();
        ArrayList<Thematique> listeTheme = listeThematique(listeProp);
        for(int i = 0;i<listeTheme.size();i++){
            float budgetRestant = listeTheme.get(i).getBudget();
            ArrayList<Proposition> listePropThematique = triListePropPopularite(listeTheme.get(i).getSesPropositions());

            for(int j = 0; j<listePropThematique.size();j++){
                if(listePropThematique.get(i).getEvaluationBudgetaire() <= budgetRestant){
                    listePropApprouve.add(listePropThematique.get(i));
                    budgetRestant -= listePropThematique.get(i).getEvaluationBudgetaire();
                    listePropThematique.remove(i);
                }
            }
        }
        return listePropApprouve;


    }


    public ArrayList<Proposition> forceBruteThematiquePopularite(ArrayList<Proposition> listeProp){
        ArrayList<Thematique> listeTheme = listeThematique(listeProp);
        ArrayList<Proposition> listeFinale = new ArrayList<Proposition>();
        for(int i = 0;i<listeTheme.size();i++){
            float budgetRestant = listeTheme.get(i).getBudget();
            listeProp= listeTheme.get(i).getSesPropositions();
            listeFinale.addAll(recursifThematiquePopularite(budgetRestant,listeProp));

        }

        return listeFinale;
    }


    public ArrayList<Proposition> recursifThematiquePopularite(float budget, ArrayList<Proposition> listeProp){
        if(listeProp==null) return null;
        if(listeProp.get(0).getEvaluationBudgetaire()>budget) {
            listeProp.remove(0);
            return recursifThematiquePopularite(budget,listeProp);

        }
        ArrayList<Proposition> listeReduite = listeProp;
        listeReduite.remove(0);
        ArrayList<Proposition> listeAvec = recursifThematiquePopularite(budget-listeProp.get(0).getEvaluationBudgetaire(),listeReduite);
        ArrayList<Proposition> listeSans = recursifThematiquePopularite(budget,listeReduite);
        if(listeAvec==null) {
            listeAvec=new ArrayList<>();
        }
        else {
            listeAvec.add(listeProp.get(0));
        }
        int PopListeAvec = 0;
        float popListeAvec = 0;
        for (Proposition prop : listeAvec) {
            popListeAvec += (float) prop.getVotePour().size() / prop.getVoteTotal().size();
        }

        float popListeSans = 0;
        for (Proposition prop : listeSans) {
            popListeSans += (float) prop.getVotePour().size() / prop.getVoteTotal().size();
        }

        return (popListeSans > popListeAvec) ? listeSans : listeAvec;
    }
}

