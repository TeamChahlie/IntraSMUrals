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
import java.util.ArrayList;
import java.util.Arrays;


public class MainActivity extends Activity {

    private ListView gameList;
    private GameListAdapter gameListAdapter;
    private MainActivity mainActivity = null;
    public ArrayList<Game> gameData = new ArrayList<Game>();

    private RelativeLayout loadingLayout;
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

        mainActivity = this;
        setFakeListData();

        Resources resources = getResources();
        gameList = (ListView)findViewById(R.id.gamesListView);

        gameListAdapter = new GameListAdapter(this, gameData, resources);
        gameList.setAdapter(gameListAdapter);

        Bundle data = getIntent().getExtras();
        user = data.getParcelable("user");
        userLabel = (TextView) findViewById(R.id.userLabel);
        userLabel.setText(user.getFirstName() + " " + user.getLastName());

        loadingLayout = (RelativeLayout)findViewById(R.id.loadingPanel2);
    }

    private void setFakeListData() {
        for (int i = 0; i < 11; i++) {

            final Game game = new Game(
                    "Cricket",
                    "Team" + i,
                    "Team" + (i+1),
                    "Date of game",
                    "Time of game"
            );
            gameData.add(game);
        }
    }

    public void onItemClick(int mPosition)
    {
        Game temp = (Game) gameData.get(mPosition);
        Toast.makeText(this, temp.getTeamName() + " vs. " + temp.getOpponentName(), Toast.LENGTH_SHORT).show();
    }

    public void onLogoutClicked(View view) {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setMessage("Are you sure?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();
    }

    private class gamesRequest extends AsyncTask<String, Integer, String> {

        @Override
        protected String doInBackground(String... params) {
            String userID = user.getUserID();
            String result = "";
            try {
                URL url = new URL("http://54.69.253.21/api/login");
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
            loadingLayout.setVisibility(View.GONE);
            try {
                JSONObject object = new JSONObject(result);
                boolean isUser = object.getBoolean("isUser");
                if(isUser) {
                    JSONObject info = object.getJSONObject("info");
                    user = new User(info.getString("fname"), info.getString("lname"), info.getString("studentID"), info.getString("email"));
                } else {
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
