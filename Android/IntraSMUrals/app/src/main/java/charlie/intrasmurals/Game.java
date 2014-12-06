package charlie.intrasmurals;

import java.util.Date;

/**
 * Created by charlie on 12/5/14.
 */
public class Game {

    private String sportName;
    private String teamName;
    private String opponentName;
    private String date;
    private String time;

    public Game(String sportName, String teamName, String opponentName, String date, String time) {
        this.sportName = sportName;
        this.teamName = teamName;
        this.opponentName = opponentName;
        this.date = date;
        this.time = time;
    }

    public String getTime() {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getOpponentName() {
        return opponentName;
    }

    public void setOpponentName(String opponentName) {
        this.opponentName = opponentName;
    }

    public String getTeamName() {
        return teamName;
    }

    public void setTeamName(String teamName) {
        this.teamName = teamName;
    }

    public String getSportName() {
        return sportName;
    }

    public void setSportName(String sportName) {
        this.sportName = sportName;
    }
}
