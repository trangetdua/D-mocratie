import java.util.*;

public class VotePour {
    private Map<Integer, List<Integer>> userVotes; // Key: User ID, Value: List of Proposition IDs

    public VotePour() {
        userVotes = new HashMap<>();
    }

    public void addVote(int userId, int propositionId) {
        userVotes.putIfAbsent(userId, new ArrayList<>());
        userVotes.get(userId).add(propositionId);
    }

    public List<Integer> getVotesByUser(int userId) {
        return userVotes.getOrDefault(userId, new ArrayList<>());
    }

    public List<Integer> getUsersByProposition(int propositionId) {
        List<Integer> users = new ArrayList<>();
        for (Map.Entry<Integer, List<Integer>> entry : userVotes.entrySet()) {
            if (entry.getValue().contains(propositionId)) {
                users.add(entry.getKey());
            }
        }
        return users;
    }
}
