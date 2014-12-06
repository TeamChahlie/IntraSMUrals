package charlie.intrasmurals;

import android.app.Activity;
import android.content.Context;
import android.content.res.Resources;
import android.graphics.Color;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by charlie on 12/5/14.
 */
public class GameListAdapter extends BaseAdapter implements View.OnClickListener {

    private Activity activity;
    private ArrayList data;
    private static LayoutInflater inflater = null;
    public Resources resources;
    private Game temp = null;

    public GameListAdapter(Activity a, ArrayList l, Resources r) {
        activity = a;
        data = l;
        resources = r;

        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }
    @Override
    public int getCount() {
        return data.size();
    }

    @Override
    public Object getItem(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    public static class ViewHolder{
        public ImageView image;
        public TextView sportName;
        public TextView matchup;
        public TextView date;
        public TextView time;
        public TextView score;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = convertView;
        ViewHolder holder;

        if (convertView == null) {
            view = inflater.inflate(R.layout.game_item, null);

            holder = new ViewHolder();
            holder.image = (ImageView)view.findViewById(R.id.imageView);
            holder.sportName = (TextView)view.findViewById(R.id.sportLabel);
            holder.matchup = (TextView)view.findViewById(R.id.matchup);
            holder.date = (TextView)view.findViewById(R.id.dateLabel);
            holder.time = (TextView)view.findViewById(R.id.timeLabel);
            holder.score = (TextView)view.findViewById(R.id.scoreLabel);

            view.setTag(holder);
        } else
            holder = (ViewHolder)view.getTag();

        if (data.size() <= 0) {
            holder.sportName.setText("No Data");
        } else {
            temp = null;
            temp = (Game) data.get(position);

            /************  Set Model values in Holder elements ***********/
            int imageID = resources.getIdentifier(temp.getSportName().toLowerCase().replace(" ", "_"), "drawable", "charlie.intrasmurals");
            int defaultID = resources.getIdentifier("unknown", "drawable", "charlie.intrasmurals");
            if (imageID != 0) {
                holder.image.setImageResource(imageID);
            } else {
                holder.image.setImageResource(defaultID);
            }
            holder.sportName.setText(temp.getSportName());
            holder.matchup.setText(temp.getTeamName() + " vs. " + temp.getOpponentName());
            holder.date.setText(temp.getDate());
            holder.time.setText(temp.getTime());

            int teamScore = Integer.valueOf(temp.getTeamScore());
            int opponentScore = Integer.valueOf(temp.getOpponentScore());
            if(teamScore == 99999 || opponentScore == 99999) {
                holder.score.setText("");
            } else if(teamScore > opponentScore) {
                holder.score.setText("WIN: " + teamScore + " - " + opponentScore);
                holder.score.setTextColor(Color.parseColor("#00CC00"));
            } else if (opponentScore > teamScore) {
                holder.score.setText("LOSS: " + opponentScore + " - " + teamScore);
            } else {
                holder.score.setText("TIE: " + teamScore + " - " + opponentScore);
                holder.score.setTextColor(Color.DKGRAY);
            }

            /******** Set Item Click Listner for LayoutInflater for each row *******/

            view.setOnClickListener(new OnItemClickListener(position));
        }
        return view;
    }

    private class OnItemClickListener  implements View.OnClickListener {
        private int mPosition;

        OnItemClickListener(int position){
            mPosition = position;
        }

        @Override
        public void onClick(View arg0) {


            MainActivity ma = (MainActivity)activity;

            /****  Call  onItemClick Method inside CustomListViewAndroidExample Class ( See Below )****/

            ma.onItemClick(mPosition);
        }
    }

    @Override
    public void onClick(View v) {

    }
}
