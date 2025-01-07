package application;

import java.util.*;

public class StrategieOptimisee {

    private Map<String, List<Proposition>> memo; // Bảng lưu trữ memoization

    public StrategieOptimisee() {
        this.memo = new HashMap<>();
    }

    public List<Proposition> minimiserBudgetOp(List<Utilisateur> users, List<Proposition> propositions, VotePour votes) {
        Set<Integer> selectedPropositions = new HashSet<>();
        Set<Integer> satisfiedUsers = new HashSet<>();
        Map<Integer, Double> propositionCosts = new HashMap<>();

        // Tạo bản đồ chi phí cho mỗi đề xuất
        for (Proposition prop : propositions) {
            propositionCosts.put(prop.getId(), (double) prop.getEvaluationBudgetaire());
        }

        // Duyệt qua từng người dùng
        for (Utilisateur user : users) {
            List<Integer> userVotes = votes.getVotesByUser(user.getId());

            // Dùng PriorityQueue để chọn đề xuất rẻ nhất
            PriorityQueue<Integer> minHeap = new PriorityQueue<>(
                    Comparator.comparingDouble(propositionCosts::get)
            );

            // Thêm tất cả các phiếu bầu của người dùng vào minHeap
            for (int vote : userVotes) {
                if (!selectedPropositions.contains(vote)) { // Chỉ thêm nếu chưa được chọn
                    minHeap.add(vote);
                }
            }

            // Lấy đề xuất rẻ nhất từ PriorityQueue
            if (!minHeap.isEmpty()) {
                int bestProp = minHeap.poll();
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


    // Brute force tối ưu hóa với memoization
    public List<Proposition> bruteForceWithMemoization(List<Proposition> propositions, double budgetLimit) {
        return bruteForceHelper(propositions, budgetLimit, 0);
    }

    // Hàm trợ giúp đệ quy với memoization
    private List<Proposition> bruteForceHelper(List<Proposition> propositions, double budgetLimit, int index) {
        // Điều kiện dừng
        if (index >= propositions.size() || budgetLimit <= 0) {
            return new ArrayList<>();
        }

        // Tạo khóa duy nhất cho trạng thái hiện tại
        String key = index + "|" + budgetLimit;

        // Nếu kết quả đã được tính trước đó, trả về kết quả từ memo
        if (memo.containsKey(key)) {
            return memo.get(key);
        }

        // Lựa chọn 1: Không chọn đề xuất hiện tại
        List<Proposition> exclude = bruteForceHelper(propositions, budgetLimit, index + 1);

        // Lựa chọn 2: Chọn đề xuất hiện tại (nếu còn đủ ngân sách)
        List<Proposition> include = new ArrayList<>();
        Proposition current = propositions.get(index);
        if (current.getEvaluationBudgetaire() <= budgetLimit) {
            include.add(current);
            include.addAll(bruteForceHelper(propositions, budgetLimit - current.getEvaluationBudgetaire(), index + 1));
        }

        // So sánh hai lựa chọn (giả sử tối ưu hóa dựa trên tổng số phiếu bầu)
        List<Proposition> result = (getVoteCount(include) > getVoteCount(exclude)) ? include : exclude;

        // Lưu kết quả vào memo
        memo.put(key, result);

        return result;
    }

    // Hàm tính tổng số phiếu bầu (ví dụ)
    private int getVoteCount(List<Proposition> propositions) {
        int count = 0;
        for (Proposition prop : propositions) {
            count += prop.getVoteCount(); // Giả sử Proposition có phương thức getVoteCount()
        }
        return count;
    }
}

