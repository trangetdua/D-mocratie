package application;

import java.util.*;

public class Decision {
    float budgetTotal = 100000.0f;
    float budget = 0;

    int comparerPropo(Proposition propo, List<Utilisateur> satisfaction) {
        int nbCommun = 0;
        for (Utilisateur user : propo.getVotePour()) {
            if (satisfaction.contains(user)) {
                nbCommun += 1;
            }
        }
        return nbCommun;
    }
    int propoRepartie(List<Proposition> propos, List<Utilisateur> satisfaction) {
        int indexFinal = 0;
        int maxi = 0;
        if (satisfaction.isEmpty()) {
            for (int i = 0; i < propos.size(); i++) {
                if (propos.get(i).getVotePour().size() > maxi) {
                    maxi = propos.get(i).getVotePour().size();
                    indexFinal = i;
                }
            }
        } else {
            int commun;
            for (int i = 0; i < propos.size(); i++) {
                commun = comparerPropo(propos.get(i), satisfaction);
                if (commun > maxi) {
                    maxi = commun;
                    indexFinal = i;
                }
            }
        }
        return indexFinal;
    }

    int propoMax(List<Proposition> propos, List<Utilisateur> satisfaction) {
        int indexFinal = 0;
        int maxi = 0;
        for (int i = 0; i < propos.size(); i++) {
            if (propos.get(i).getVotePour().size() > maxi) {
                maxi = propos.get(i).getVotePour().size();
                indexFinal = i;
            }
        }
        return indexFinal;
    }

    List<Utilisateur> updateSatisfaction(Proposition propo, List<Utilisateur> satisfaction, VotePour votes) {
        List<Integer> userIds = votes.getUsersByProposition(propo.getId());
        for (Integer userId : userIds) {
            Utilisateur user = satisfaction.stream()
                    .filter(u -> u.getId() == userId)
                    .findFirst()
                    .orElse(null);
            if (user != null) {
                satisfaction.remove(user);
            }
        }
        return satisfaction;
    }

    @SuppressWarnings("null")
    List<Proposition> descisionGlouton(List<Proposition> propos, float budgetTotal, VotePour votes, Map<Integer, Utilisateur> userMap) {
        List<Proposition> listFinal = new ArrayList<>();
        List<Utilisateur> satisfaction = new ArrayList<>(userMap.values());
        float budget = 0f;

        while (!propos.isEmpty()) {
            int indexPropo = propoMax(propos, satisfaction);
            if (propos.get(indexPropo).getEvaluationBudgetaire() + budget <= budgetTotal) {
                budget += propos.get(indexPropo).getEvaluationBudgetaire();
                satisfaction = updateSatisfaction(propos.get(indexPropo), satisfaction, votes);
                listFinal.add(propos.get(indexPropo));
            }
            propos.remove(indexPropo);
        }
        return listFinal;
    }

    @SuppressWarnings("null")
    ArrayList<Proposition> descisionGlouton2 (ArrayList<Proposition> propos , float budgetTotal){
        //votes repartie
        ArrayList<Proposition> listFinal = null;
        List<Utilisateur> satisfaction = null;
        float budget = 0f;
        for (int i=0; i<propos.size(); i++) {
            for(int j=0; j<propos.get(i).getVotePour().size(); j++) {
                if (!satisfaction.contains(propos.get(i).getVotePour().get(j))){
                    satisfaction.add(propos.get(i).getVotePour().get(j));
                }
            }
        }
        while (!propos.isEmpty()) {
            int indexPropo = propoMax(propos, satisfaction);
            if (propos.get(indexPropo).getEvaluationBudgetaire() + budget <= budgetTotal) {
                budget += propos.get(indexPropo).getEvaluationBudgetaire();
                satisfaction = updateSatisfaction(propos.get(indexPropo), satisfaction,new VotePour());
                listFinal.add(propos.get(indexPropo));
            }
            propos.remove(indexPropo);
        }
        return listFinal;
    }

    public static int nbSatisfait(List<Proposition> propos, VotePour votes) {
        Set<Integer> satisfiedUsers = new HashSet<>();

        for (Proposition prop : propos) {
            satisfiedUsers.addAll(votes.getUsersByProposition(prop.getId()));
        }

        return satisfiedUsers.size();
    }

    public static ArrayList<Proposition> FBSatisfaction(ArrayList<Proposition> propos, float budgetTotal, VotePour votes) {
        /* Cas de base. */
        if (propos == null || propos.isEmpty()) {
            return new ArrayList<>();
        }

        if (propos.get(0).getEvaluationBudgetaire() > budgetTotal) {
            /* On ne peut pas prendre l'objet, donc pas le choix */
            ArrayList<Proposition> newPropos = new ArrayList<>(propos);
            newPropos.remove(0);
            return FBSatisfaction(newPropos, budgetTotal, votes);
        }

        Proposition aGarder = propos.get(0);
        ArrayList<Proposition> newProposSans = new ArrayList<>(propos);
        ArrayList<Proposition> newProposAvec = new ArrayList<>(propos);

        newProposSans.remove(0);
        newProposAvec.remove(0);

        ArrayList<Proposition> choixSans = FBSatisfaction(newProposSans, budgetTotal, votes);
        ArrayList<Proposition> choixAvec = FBSatisfaction(newProposAvec, budgetTotal - aGarder.getEvaluationBudgetaire(), votes);

        if (choixAvec == null) {
            choixAvec = new ArrayList<>();
            choixAvec.add(aGarder);
        } else {
            choixAvec.add(aGarder);
        }

        return (nbSatisfait(choixSans, votes) > nbSatisfait(choixAvec, votes)) ? choixSans : choixAvec;
    }


}