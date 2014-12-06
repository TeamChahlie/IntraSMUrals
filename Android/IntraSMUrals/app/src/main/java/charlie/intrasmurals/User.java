package charlie.intrasmurals;

import android.os.Parcel;
import android.os.Parcelable;

/**
 * Created by charlie on 12/5/14.
 */
public class User implements Parcelable {

    private String firstName;
    private String lastName;
    private String userID;
    private String email;

    public User(String firstName, String lastName, String userID, String email) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.userID = userID;
        this.email = email;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getUserID() {
        return userID;
    }

    public void setUserID(String userID) {
        this.userID = userID;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    @Override

    public String toString() {
        return "\nFirst Name: " + this.firstName + "\nLast Name: " + this.lastName + "\nUser ID: " + this.userID + "\nEmail: " + this.email;
    }

    public User(Parcel in) {
        String[] data = new String[4];
        in.readStringArray(data);
        this.firstName = data[0];
        this.lastName = data[1];
        this.userID = data[2];
        this.email = data[3];
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeStringArray(new String[] {
                this.firstName,
                this.lastName,
                this.userID,
                this.email
        });
    }

    public static final Parcelable.Creator CREATOR = new Parcelable.Creator() {
        public User createFromParcel(Parcel in) {
            return new User(in);
        }

        public User[] newArray(int size) {
            return new User[size];
        }
    };
}
