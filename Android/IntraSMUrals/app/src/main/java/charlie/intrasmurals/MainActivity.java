package charlie.intrasmurals;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.res.Resources;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.awt.font.TextAttribute;
import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.lang.reflect.Array;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.Comparator;
import java.util.Date;


public class MainActivity extends Activity {

    private ListView gameList;
    private GameListAdapter gameListAdapter;
    private MainActivity mainActivity;
    public ArrayList<Game> gameData = new ArrayList<Game>();

    private RelativeLayout loadingScreen;

    private TextView noGamesLabel;
    private TextView userLabel;
    private User user;
    private String[] sports = new String[] {
            "Football",
            "Basketball",
            "Baseball",
            "Soccer"
    };
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        loadingScreen = (RelativeLayout)findViewById(R.id.loadingScreen);
        noGamesLabel = (TextView)findViewById(R.id.noGamesLabel);
        mainActivity = this;


        final Resources resources = getResources();
        gameList = (ListView)findViewById(R.id.gamesListView);

        gameListAdapter = new GameListAdapter(this, gameData, resources);
        gameList.setAdapter(gameListAdapter);

        Bundle data = getIntent().getExtras();
        user = data.getParcelable("user");
        userLabel = (TextView) findViewById(R.id.userLabel);
        userLabel.setText(user.getFirstName() + " " + user.getLastName());
        getGameData();
    }

    private void getGameData() {
        loadingScreen.setVisibility(View.VISIBLE);
        new gamesRequest().execute(user.getUserID());
    }

    public void onItemClick(int mPosition)
    {
//        Game temp = (Game) gameData.get(mPosition);
//        Toast.makeText(this, temp.getTeamName() + " vs. " + temp.getOpponentName(), Toast.LENGTH_SHORT).show();
    }

    public void onLogoutClicked(View view) {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setMessage("Are you sure?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();
    }

    private class gamesRequest extends AsyncTask<String, Integer, String> {

        @Override
        protected String doInBackground(String... params) {
            String userID = params[0];
            String result = "";
            try {
                URL url = new URL("http://54.69.253.21/api/getStudentMatches");
                HttpURLConnection connection;
                connection = (HttpURLConnection) url.openConnection();
                connection.setReadTimeout(10000);
                connection.setConnectTimeout(15000);
                connection.setRequestMethod("POST");
                connection.setRequestProperty("Content-Type", "application/json");
                connection.setRequestProperty("Accept", "application/json");

                JSONObject credentials = new JSONObject();
                credentials.put("studentID", userID);

                final String json = credentials.toString();
                connection.getOutputStream().write(json.getBytes());
                connection.getOutputStream().flush();
                connection.connect();

                final int statusCode = connection.getResponseCode();
                if (statusCode != HttpURLConnection.HTTP_OK) {
                    Log.d("ASYNC", "The request failed with status code: " + statusCode + ". Use the status code to debug this problem.");
                } else {
                    InputStream in = new BufferedInputStream(connection.getInputStream());
                    result = getResponseText(in);
                }
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return result;
        }

        @Override
        protected void onProgressUpdate(Integer... params) {

        }

        @Override
        protected void onPostExecute(String result) {
            loadingScreen.setVisibility(View.GONE);
            try {
                JSONObject object = new JSONObject(result);
                boolean hasGames = object.getBoolean("hasGames");
                if(hasGames) {
                    JSONArray games = object.getJSONArray("games");
                    for (int i = 0; i < games.length(); i++) {
                        JSONObject game = games.getJSONObject(i);
                        String teamScore = game.getString("teamScore");
                        String opponentScore = game.getString("opponentScore");
                        if (teamScore.equals("null") || opponentScore.equals("null")) {
                            teamScore = "99999";
                            opponentScore = "99999";
                        }

                        Game newGame = new Game(
                                game.getString("sportName"),
                                game.getString("teamName"),
                                game.getString("opponentName"),
                                game.getString("date"),
                                game.getString("time"),
                                teamScore,
                                opponentScore
                        );
                        gameData.add(newGame);
                    }
                    Collections.sort(gameData, new Comparator<Game>() {
                        @Override
                        public int compare(Game lhs, Game rhs) {
                            Log.d("DATE", "SORTING");
                            SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd");
                            try {
                                Date lhsDate = format.parse(lhs.getDate());
                                Date rhsDate = format.parse(rhs.getDate());
                                Log.d("DATE", String.valueOf(lhsDate));
                                Log.d("DATE", String.valueOf(rhsDate));
                                return rhsDate.compareTo(lhsDate);
                            } catch (ParseException e) {
                                e.printStackTrace();
                                return 0;
                            }
                        }
                    });
                } else {
                    noGamesLabel.setVisibility(View.VISIBLE);
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    private String getResponseText(InputStream in) throws IOException {
        BufferedReader reader = new BufferedReader(new InputStreamReader(in));
        StringBuilder sb = new StringBuilder();
        String line = reader.readLine();
        while (line != null) {
            sb.append(line + "\n");
            line = reader.readLine();
        }
        return sb.toString();
    }

    DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
        @Override
        public void onClick(DialogInterface dialog, int which) {
            switch (which){
                case DialogInterface.BUTTON_POSITIVE:
                    Intent intent = new Intent(mainActivity, LoginActivity.class);
                    startActivity(intent);
                    break;

                case DialogInterface.BUTTON_NEGATIVE:
                    dialog.cancel();
                    break;
            }
        }
    };

    private void makeToast(String text) {
        Toast.makeText(this, text, Toast.LENGTH_SHORT).show();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
