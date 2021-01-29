package com.example.sportsclub.activities;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.example.sportsclub.Constants;
import com.example.sportsclub.R;

import org.json.JSONObject;

import butterknife.BindView;
import butterknife.ButterKnife;

public class AcceptActivity extends AppCompatActivity {
    @BindView(R.id.toolbar)
    Toolbar toolbar;
    @BindView(R.id.toolbar_title)
    TextView mTitle;
    @BindView(R.id.btAcc)
    Button btAcc;
    @BindView(R.id.etNameTeam)
    EditText etNameTeam;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_accept);
        ButterKnife.bind(this);

        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        mTitle.setText("Accept Match");

        Intent intent = getIntent();
        String id = intent.getStringExtra("id");

        btAcc.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String nameTeam = etNameTeam.getText().toString().trim();

                AndroidNetworking.post(Constants.BASE_URL + "/api/acc/{id}")
                        .addPathParameter("id", id)
                        .addBodyParameter("teamAcc", nameTeam)
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONObject(new JSONObjectRequestListener() {
                            @Override
                            public void onResponse(JSONObject response) {
                                Intent intent = new Intent(AcceptActivity.this, AllMatchActivity.class);
                                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                startActivity(intent);
                            }

                            @Override
                            public void onError(ANError error) {
                                Toast.makeText(AcceptActivity.this, Constants.TOAST_AN_ERROR, Toast.LENGTH_SHORT).show();
                                Log.d("SCA", "onErrorBody: " + error.getErrorBody());
                                Log.d("SCA", "onErrorLocalMessage: " + error.getLocalizedMessage());
                                Log.d("SCA", "onErrorResponse: " + error.getResponse());
                                Log.d("SCA", "onErrorCode: " + error.getErrorCode());
                                Log.d("SCA", "onErrorDetail: " + error.getErrorDetail());
                            }
                        });
            }
        });
    }

    public boolean onSupportNavigateUp() {
        finish();
        return true;
    }
}
