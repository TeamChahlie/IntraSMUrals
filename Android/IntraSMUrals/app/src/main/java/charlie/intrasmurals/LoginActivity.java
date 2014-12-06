package charlie.intrasmurals;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextUtils;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;


public class LoginActivity extends Activity {

    private EditText emailField;
    private EditText passwordField;
    private RelativeLayout loadingLayout;
    private User user;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        emailField = (EditText) findViewById(R.id.emailField);
        passwordField = (EditText) findViewById(R.id.passwordField);
        loadingLayout = (RelativeLayout) findViewById(R.id.loadingPanel);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.login, menu);
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


    public void onLoginClicked(View view) {

        String emailVal = emailField.getText().toString();
        String passVal = passwordField.getText().toString();

        if (emailVal.isEmpty() || passVal.isEmpty()) {
            Toast.makeText(this, "Please enter both an email and password.", Toast.LENGTH_SHORT).show();
        } else {
            boolean valid = isValidEmail(emailField.getText());
            if(!valid) {
                Toast.makeText(this, "Email address is not a valid format.", Toast.LENGTH_SHORT).show();
            } else {
                loadingLayout.setVisibility(View.VISIBLE);
                new LoginRequest().execute(emailVal, passVal);
            }
        }
    }

    public final static boolean isValidEmail(CharSequence target) {
        return !TextUtils.isEmpty(target) && android.util.Patterns.EMAIL_ADDRESS.matcher(target).matches();
    }

    private class LoginRequest extends AsyncTask<String, Integer, String> {

        @Override
        protected String doInBackground(String... params) {
            String emailVal = params[0];
            String passVal = params[1];
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
                credentials.put("email", emailVal);
                credentials.put("password", passVal);

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
                    loginComplete();
                } else {
                    makeToast("The email and/or password are incorrect");
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    private void loginComplete() {
        Intent intent = new Intent(this, MainActivity.class);
        intent.putExtra("user", user);
        startActivity(intent);
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

    private void makeToast(String text) {
        Toast.makeText(this, text, Toast.LENGTH_SHORT).show();
    }
}


