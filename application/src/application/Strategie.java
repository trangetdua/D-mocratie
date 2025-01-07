package application;

import java.util.*;

public class Strategie {

    //Chọn proposition rẻ nhất
    public List<Proposition> minimiserBudget(List<Utilisateur> users, List<Proposition> propositions, VotePour votes) {
        Set<Integer> selectedPropositions = new HashSet<>();
        Set<Integer> satisfiedUsers = new HashSet<>();
        Map<Integer, Double> propositionCosts = new HashMap<>();

        for (Proposition prop : propositions) {
            propositionCosts.put(prop.getId(), (double) prop.getEvaluationBudgetaire());
        }

        for (Utilisateur user : users) {
            List<Integer> userVotes = votes.getVotesByUser(user.getId());

            // Tìm đề xuất rẻ nhất
            int bestProp = -1;
            double minCost = Double.MAX_VALUE;

            for (int prop : userVotes) {
                if (!selectedPropositions.contains(prop) && propositionCosts.get(prop) < minCost) {
                    bestProp = prop;
                    minCost = propositionCosts.get(prop);
                }
            }

            // Thêm đề xuất rẻ nhất
            if (bestProp != -1) {
                selectedPropositions.add(bestProp);
                satisfiedUsers.add(user.getId());
            }
        }

        // Tạo danh sách kết quả
        List<Proposition> result = new ArrayList<>();
        for (Proposition prop : propositions) {
            if (selectedPropositions.contains(prop.getId())) {
                result.add(prop);
            }
        }

        return result;
    }

    // Chọn các đề xuất phổ biến nhất trong giới hạn ngân sách
    public List<Proposition> popularProposals(List<Proposition> propositions, VotePour votes, double budgetLimit) {
        // Bước 1: Tính tổng số phiếu bầu cho mỗi đề xuất
        Map<Integer, Integer> voteCounts = new HashMap<>();
        for (Proposition prop : propositions) {
            int count = votes.getUsersByProposition(prop.getId()).size(); // Lấy số người dùng đã vote cho đề xuất
            voteCounts.put(prop.getId(), count);
        }

        // Bước 2: Sắp xếp các đề xuất theo số phiếu (giảm dần), nếu số phiếu bằng nhau thì ưu tiên chi phí thấp
        propositions.sort((p1, p2) -> {
            int count1 = voteCounts.getOrDefault(p1.getId(), 0);
            int count2 = voteCounts.getOrDefault(p2.getId(), 0);

            if (count1 != count2) {
                return Integer.compare(count2, count1); // Sắp xếp theo số phiếu (giảm dần)
            } else {
                return Double.compare(p1.getEvaluationBudgetaire(), p2.getEvaluationBudgetaire()); // Ưu tiên chi phí thấp
            }
        });

        // Bước 3: Chọn đề xuất đầu tiên thỏa mãn giới hạn ngân sách
        List<Proposition> result = new ArrayList<>();

        for (Proposition prop : propositions) {
            if (prop.getEvaluationBudgetaire() <= budgetLimit) {
                result.add(prop); // Thêm đề xuất đầu tiên thỏa mãn ngân sách
                break; // Dừng ngay sau khi chọn được
            }
        }

        return result;
    }

}
