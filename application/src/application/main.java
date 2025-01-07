package application;

import java.util.*;

public class main {
	
	
    public static void main(String[] args) {
        // Dữ liệu mô phỏng
    	List<Utilisateur> users = Arrays.asList(
                new Utilisateur(1, "Doe"),
                new Utilisateur(2, "Smith"),
                new Utilisateur(3, "Brown"),
                new Utilisateur(4, "Taylor"),
                new Utilisateur(5, "Johnson")
        );

        Proposition p1 = new Proposition(1, "Installer des poubelles de tri", 1500);
        Proposition p2 = new Proposition(2, "Creer une equipe de football", 5000);
        Proposition p3 = new Proposition(3, "Organiser un hackathon", 3000);
        Proposition p4 = new Proposition(4, "Ateliers sante", 2000);
        Proposition p5 = new Proposition(5, "Campagne alphabetisation", 2500);
        Proposition p6 = new Proposition(6, "Jardin communautaire", 1800);
        Proposition p7 = new Proposition(7, "Cours d'informatique", 2200);
        Proposition p8 = new Proposition(8, "Nettoyage de la plage", 1600);

        ArrayList<Proposition> propositionsEnvironnement = new ArrayList<>(Arrays.asList(p1, p8));
        ArrayList<Proposition> propositionsSport = new ArrayList<>(Arrays.asList(p2, p6));
        ArrayList<Proposition> propositionsEducation = new ArrayList<>(Arrays.asList(p3, p5, p7));
        ArrayList<Proposition> propositionsSante = new ArrayList<>(Arrays.asList(p4));

        Thematique environnement = new Thematique();
        environnement.setNom("Environnement");
        environnement.setBudget(5000);
        environnement.setSesPropositions(propositionsEnvironnement);

        Thematique sport = new Thematique();
        sport.setNom("Sport");
        sport.setBudget(7000);
        sport.setSesPropositions(propositionsSport);

        Thematique education = new Thematique();
        education.setNom("Education");
        education.setBudget(8000);
        education.setSesPropositions(propositionsEducation);

        Thematique sante = new Thematique();
        sante.setNom("Sante");
        sante.setBudget(3000);
        sante.setSesPropositions(propositionsSante);

        // Danh sách các thématiques
        ArrayList<Thematique> thematiques = new ArrayList<>(Arrays.asList(environnement, sport, education, sante));

        List<Proposition> propositions = new ArrayList<>();
        propositions.addAll(propositionsEnvironnement);
        propositions.addAll(propositionsSport);
        propositions.addAll(propositionsEducation);
        propositions.addAll(propositionsSante);



        VotePour votes = new VotePour();
        votes.addVote(1, 1);
        votes.addVote(1, 2);
        votes.addVote(1, 3);
        votes.addVote(2, 2);
        votes.addVote(2, 3);
        votes.addVote(2, 4);
        votes.addVote(2, 5);
        votes.addVote(3, 1);
        votes.addVote(3, 4);
        votes.addVote(3, 5);
        votes.addVote(3, 3);
        votes.addVote(4, 2);
        votes.addVote(4, 3);
        votes.addVote(4, 5);
        votes.addVote(5, 1);
        votes.addVote(5, 3);
        votes.addVote(5, 4);
        votes.addVote(5, 2);
        


        // Khởi tạo chiến lược
        Strategie strategie = new Strategie();
        StrategieOptimisee strategieOptimisee = new StrategieOptimisee();
        Scanner scanner = new Scanner(System.in);

        while (true) {
            // Hiển thị danh sách người dùng
            System.out.println("\nListe des utilisateus:");
            for (Utilisateur user : users) {
                System.out.println("ID: " + user.getId() + ", Nom: " + user.getNom());
            }

            // Người dùng chọn một người dùng theo ID
            System.out.print("\nSaisir ID pour se connecter (0 pour exit): ");
            int userId = scanner.nextInt();
            scanner.nextLine();

            if (userId == 0) {
                System.out.println("Sorti !.");
                break;
            }

            // Tìm người dùng theo ID
            Optional<Utilisateur> selectedUser = users.stream()
                    .filter(user -> user.getId() == userId)
                    .findFirst();

            if (selectedUser.isPresent()) {
                Utilisateur user = selectedUser.get();
                System.out.println("\nVous avez connecté en tant que: " + user.getNom());

                System.out.println("\nSélectionner une fonctionnalité:");
                System.out.println("1. Minimiser le budget, tout en garantissant que chaque utilisateur a au moins un vote satisfait.\n");
                System.out.println("2. Maximiser le nombre total de votes satisfaits tout en garantissant les contraintes de budget.");
                System.out.println("3.Maximiser le pourcentage de popularité des propositions acceptées par thématique tout en respectant le budget.");

                int choice = scanner.nextInt();
                scanner.nextLine();

                if (choice == 1) {
                    // Liste des votes
                    List<Integer> userVotes = votes.getVotesByUser(userId);
                    if (!userVotes.isEmpty()) {
                        System.out.println("Votre liste de propositions votées:");
                        List<Proposition> userPropositions = new ArrayList<>();

                        for (int voteId : userVotes) {
                            propositions.stream()
                                    .filter(prop -> prop.getId() == voteId)
                                    .findFirst()
                                    .ifPresent(userPropositions::add);
                        }

                        for (Proposition prop : userPropositions) {
                            System.out.println("- " + prop.getTitre() + " (Coût: " + prop.getEvaluationBudgetaire() + ")");
                        }


                        // Gọi thuật toán cho các phiếu bầu của người dùng
                        System.out.println("\nSélectionner le mode de décision:");
                        System.out.println("1. Minimiser le budget");
                        System.out.println("2. Propositions les plus populaires (avec la contrainte de budget)");
                        System.out.println("3. Minimiser avec l'optimisation");
                        System.out.println("4. Brute force avec memoization (optimisé)");

                        int choix = scanner.nextInt();
                        scanner.nextLine(); // Xử lý dòng trống sau nextInt()

                        if (choix == 1) {
                            List<Proposition> result = strategie.minimiserBudget(
                                    Collections.singletonList(user), // Current user
                                    userPropositions,
                                    votes
                            );
                            System.out.println("Résultat du Glouton 1:");
                            result.forEach(System.out::println);

                            double totalCost = result.stream()
                                    .mapToDouble(Proposition::getEvaluationBudgetaire)
                                    .sum();
                            System.out.println("Somme d'argent inversé: " + totalCost);

                        } else if (choix == 2) {
                            System.out.print("Limite de budget: ");
                            String input = scanner.nextLine();
                            input = input.replace(",", ".");
                            try {
                                double budgetLimit = Double.parseDouble(input);

                                List<Proposition> result = strategie.popularProposals(propositions, votes, budgetLimit);

                                // In kết quả
                                System.out.println("Résultat Brute Force 1:");
                                result.forEach(System.out::println);

                                double totalCost = result.stream()
                                        .mapToDouble(Proposition::getEvaluationBudgetaire)
                                        .sum();
                                System.out.println("Somme d'argent inversée: " + totalCost);
                            } catch (NumberFormatException e) {
                                System.out.println("Erreur de saisi");
                            }

                        } else if (choix == 4) {
                            // Chạy brute force với memoization
                            System.out.print("Limite budget: ");
                            String input = scanner.nextLine();
                            input = input.replace(",", ".");
                            try {
                                double budgetLimit = Double.parseDouble(input);

                                List<Proposition> result = strategieOptimisee.bruteForceWithMemoization(propositions, budgetLimit);

                                // In kết quả
                                System.out.println("Resultat de brute force avec memoization:");
                                result.forEach(System.out::println);

                                double totalCost = result.stream()
                                        .mapToDouble(Proposition::getEvaluationBudgetaire)
                                        .sum();
                                System.out.println("Somme d'argent inversée: : " + totalCost);
                            } catch (NumberFormatException e) {
                                System.out.println("Erreur.");
                            }

                        } else if (choix == 3) {
                            List<Proposition> result = strategieOptimisee.minimiserBudgetOp(
                                    Collections.singletonList(user),
                                    userPropositions,
                                    votes
                            );
                            System.out.println("Greedy optimisee:");
                            result.forEach(System.out::println);

                            double totalCost = result.stream()
                                    .mapToDouble(Proposition::getEvaluationBudgetaire)
                                    .sum();
                            System.out.println("Somme d'argent inversée:" + totalCost);

                        } else {
                            System.out.println("Erreur de choix.");
                        }
                    } else {
                        System.out.println("Cet utilisateur n'a voté pour aucune proposition.");
                    }


                } 
                else if (choice == 2) {
                	System.out.println("\nSélectionner le mode d'optimisation thématique:");
                    System.out.println("1. Glouton (satisfaire la majorité)");
                    System.out.println("2. Glouton (le plus de voteur satisfait au total)");
                    System.out.println("3. Force Brute (Maximiser le nombre total de votes satisfaits)");
                    float budgetTotal = 100.0f;
                    int choix = scanner.nextInt();
                    scanner.nextLine();
                    
                    if (choix == 1) {
                    	List<Proposition> result = Decision.descisionGlouton(propositions, budgetTotal, votes);
						
                        System.out.println("satisfaire la majorité:");
                        result.forEach(System.out::println);
                    }
                    
                    if (choix == 2) {
                    	ArrayList<Proposition> result2 = Decision.descisionGlouton2(new ArrayList<>(propositions), budgetTotal);
						
                        System.out.println("le plus de voteur satisfait au total:");
                        result2.forEach(System.out::println);
                    }
                    
                    if (choix == 3) {
                    	ArrayList<Proposition> resultMaxVotes = Decision.FBSatisfaction(new ArrayList<>(propositions), 10000, votes);
                    System.out.println("Résultat Maximiser Votes Satisfaits:");
                    resultMaxVotes.forEach(System.out::println);
                    }
                    
                    

                } else if (choice == 3) {
                    algo algo = new algo();

                    System.out.println("\nSélectionner le mode d'optimisation thématique:");
                    System.out.println("1. Glouton (Thematique Popularité)");
                    System.out.println("2. Force Brute (Thematique Popularité)");

                    int choix = scanner.nextInt();
                    scanner.nextLine();

                    if (choix == 1) {
                        List<Proposition> result = algo.gloutonThematiquePopularite(new ArrayList<>(propositions));
                        System.out.println("Résultat de Glouton (Popularité Thématique):");
                        result.forEach(System.out::println);

                        double totalCost = result.stream()
                                .mapToDouble(Proposition::getEvaluationBudgetaire)
                                .sum();
                        System.out.println("Somme d'argent utilisée: " + totalCost);

                    }else if (choix == 2) {

                        List<Proposition> result = algo.forceBruteThematiquePopularite(new ArrayList<>(propositions));
                        System.out.println("Résultat de Force Brute (Popularité Thématique):");
                        result.forEach(System.out::println);

                        double totalCost = result.stream()
                                .mapToDouble(Proposition::getEvaluationBudgetaire)
                                .sum();
                        System.out.println("Somme d'argent utilisée: " + totalCost);
                    }  else {
                        System.out.println("Erreur de choix.");
                    }
                }
            }

        }
        scanner.close();
    }


}
