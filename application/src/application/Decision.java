package application;

import java.util.*;

public class Decision {
    float budgetTotal = 100000.0f;
    float budget = 0;

    static int comparerPropo(Proposition propo, List<Utilisateur> satisfaction) {
        int nbCommun = 0;
        // Compte combien d'utilisateurs de la proposition sont déjà satisfaits
        for (Utilisateur user : propo.getVotePour()) {
            if (satisfaction.contains(user)) {
                nbCommun += 1;
            }
        }
        return nbCommun;
    }

    static int propoRepartie(List<Proposition> propos, List<Utilisateur> satisfaction, float budgetTotal, float currentBudget) {
        int indexFinal = -1;
        int maxiSatisfaction = 0;
        float maxBudgetEvaluation = 0;

        for (int i = 0; i < propos.size(); i++) {
            Proposition propo = propos.get(i);
            if (propo.getEvaluationBudgetaire() + currentBudget <= budgetTotal) {
                int satisfactionCount = comparerPropo(propo, satisfaction);
                if (satisfactionCount > maxiSatisfaction || (satisfactionCount == maxiSatisfaction && propo.getEvaluationBudgetaire() < maxBudgetEvaluation)) {
                    maxiSatisfaction = satisfactionCount;
                    indexFinal = i;
                    maxBudgetEvaluation = propo.getEvaluationBudgetaire();
                }
            }
        }
        return indexFinal;
    }

    static int propoMax(List<Proposition> propos, float budgetTotal, float currentBudget) {
        int indexFinal = -1;
        int maxiSatisfaction = 0;
        float maxBudgetEvaluation = 0;

        for (int i = 0; i < propos.size(); i++) {
            Proposition propo = propos.get(i);
 
            if (propo.getEvaluationBudgetaire() + currentBudget <= budgetTotal) {
                int satisfactionCount = propo.getVotePour().size();
                if (satisfactionCount > maxiSatisfaction || (satisfactionCount == maxiSatisfaction && propo.getEvaluationBudgetaire() < maxBudgetEvaluation)) {
                    maxiSatisfaction = satisfactionCount;
                    indexFinal = i;
                    maxBudgetEvaluation = propo.getEvaluationBudgetaire();
                }
            }
        }
        return indexFinal;
    }

    static List<Utilisateur> updateSatisfaction(Proposition propo, List<Utilisateur> satisfaction, VotePour votes) {
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
	static List<Proposition> descisionGlouton(List<Proposition> propos, float budgetTotal, VotePour votes) {
        List<Proposition> listFinal = new ArrayList<>();
        List<Utilisateur> satisfaction = new ArrayList<>();
        float budget = 0f;
        for (Proposition propo : propos) {
            for (Utilisateur user : propo.getVotePour()) {
                if (!satisfaction.contains(user)) {
                    satisfaction.add(user);
                }
            }
        }

        while (!propos.isEmpty()) {
            int indexPropo = propoMax(propos, budgetTotal, budget);
            if (indexPropo == -1) break;

            Proposition propo = propos.get(indexPropo);
            if (propo.getEvaluationBudgetaire() + budget <= budgetTotal) {
                budget += propo.getEvaluationBudgetaire();
                satisfaction = updateSatisfaction(propo, satisfaction, votes);
                listFinal.add(propo);
            }
            propos.remove(indexPropo);
        }

        return listFinal;
    }

    static ArrayList<Proposition> descisionGlouton2(List<Proposition> propositions, float budgetTotal) {
        ArrayList<Proposition> listFinal = new ArrayList<>();
        List<Utilisateur> satisfaction = new ArrayList<>();
        float budget = 0f;
        for (Proposition propo : propositions) {
            for (Utilisateur user : propo.getVotePour()) {
                if (!satisfaction.contains(user)) {
                    satisfaction.add(user);
                }
            }
        }
        while (!propositions.isEmpty()) {
            int indexPropo = propoRepartie(propositions, satisfaction, budgetTotal, budget);
            if (indexPropo == -1) break; 

            Proposition propo = propositions.get(indexPropo);
            if (propo.getEvaluationBudgetaire() + budget <= budgetTotal) {
                budget += propo.getEvaluationBudgetaire();
                satisfaction = updateSatisfaction(propo, satisfaction, new VotePour());
                listFinal.add(propo);
            }
            propositions.remove(indexPropo);
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