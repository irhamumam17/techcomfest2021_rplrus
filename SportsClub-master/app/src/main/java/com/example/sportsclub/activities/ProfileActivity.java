package com.example.sportsclub.activities;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.example.sportsclub.Constants;
import com.example.sportsclub.R;

import org.json.JSONException;
import org.json.JSONObject;

import butterknife.BindView;
import butterknife.ButterKnife;

import static com.example.sportsclub.activities.SignInActivity.ADDRESS;
import static com.example.sportsclub.activities.SignInActivity.EMAIL;
import static com.example.sportsclub.activities.SignInActivity.ID;
import static com.example.sportsclub.activities.SignInActivity.NAME;
import static com.example.sportsclub.activities.SignInActivity.PHONE;
import static com.example.sportsclub.activities.SignInActivity.SHARED_PREFS;
import static com.example.sportsclub.activities.SignInActivity.USERNAME;

public class ProfileActivity extends AppCompatActivity {
    @BindView(R.id.toolbar)
    Toolbar toolbar;
    @BindView(R.id.toolbar_title)
    TextView mTitle;
    @BindView(R.id.tvLogOut)
    TextView tvLogOut;
    @BindView(R.id.et_username)
    EditText et_username;
    @BindView(R.id.et_nama)
    EditText et_nama;
    @BindView(R.id.et_phone)
    EditText et_phone;
    @BindView(R.id.et_alamat)
    EditText et_alamat;
    @BindView(R.id.et_email)
    EditText et_email;
    private String id;
    private SharedPreferences sharedPreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);
        ButterKnife.bind(this);

        String title = getIntent().getStringExtra("Title");
        mTitle.setText(title);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        sharedPreferences = getSharedPreferences(SHARED_PREFS, Context.MODE_PRIVATE);
        id = sharedPreferences.getString(ID, "");

        fetchProfile();

        tvLogOut.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new AlertDialog.Builder(ProfileActivity.this)
                        .setMessage("Apakah anda yakin ingin keluar ?")
                        .setNegativeButton("Tidak", null)
                        .setPositiveButton("Ya", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface arg0, int arg1) {
                                SharedPreferences sharedPreferences = getSharedPreferences(SHARED_PREFS, Context.MODE_PRIVATE);
                                SharedPreferences.Editor editor = sharedPreferences.edit();
                                editor.clear();
                                editor.apply();
                                Intent intent = new Intent(ProfileActivity.this, LandingPageActivity.class);
                                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                startActivity(intent);
                                finish();
                            }
                        }).create().show();

            }
        });
    }

    public void fetchProfile() {
        AndroidNetworking.get(Constants.BASE_URL + "/api/profile/{id}")
                .addPathParameter("id", id)
                .setPriority(Priority.LOW)
                .build()
                .getAsJSONObject(new JSONObjectRequestListener() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONObject data = response.getJSONObject("data");
                            String name = data.getString("name");
                            String username = data.getString("username");
                            String email = data.getString("email");
                            String phoneNumber = data.getString("phone");
                            String address = data.getString("address");
                            String avatar = data.getString("avatar");
                            if (avatar != "null") {
                                avatar = Constants.BASE_URL + "/storage/" + avatar;
                            }

                            et_nama.setText(name);
                            et_username.setText(username);
                            et_email.setText(email);
                            et_phone.setText(phoneNumber);
                            et_alamat.setText(address);


                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }

                    @Override
                    public void onError(ANError anError) {
                        et_nama.setText(sharedPreferences.getString(NAME, ""));
                        et_username.setText(sharedPreferences.getString(USERNAME, ""));
                        et_email.setText(sharedPreferences.getString(EMAIL, ""));
                        et_phone.setText(sharedPreferences.getString(PHONE, ""));
                        et_alamat.setText(sharedPreferences.getString(ADDRESS, ""));
                    }
                });
    }

    public boolean onSupportNavigateUp() {
        finish();
        return true;
    }
}