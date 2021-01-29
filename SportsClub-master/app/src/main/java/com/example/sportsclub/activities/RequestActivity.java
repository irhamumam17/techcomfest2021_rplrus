package com.example.sportsclub.activities;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.DialogFragment;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.example.sportsclub.Constants;
import com.example.sportsclub.R;
import com.example.sportsclub.fragments.DatePickerFragment;
import com.example.sportsclub.model.Match;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import butterknife.BindView;
import butterknife.ButterKnife;

import static com.example.sportsclub.activities.SignInActivity.ID;
import static com.example.sportsclub.activities.SignInActivity.SHARED_PREFS;

public class RequestActivity extends AppCompatActivity implements AdapterView.OnItemSelectedListener, DatePickerDialog.OnDateSetListener {
    @BindView(R.id.toolbar)
    Toolbar toolbar;
    @BindView(R.id.toolbar_title)
    TextView mTitle;
    @BindView(R.id.edt_date)
    EditText edtDate;
    @BindView(R.id.etNameTeam)
    EditText edtNameTeam;
    @BindView(R.id.btn_req)
    Button btnReq;
    @BindView(R.id.spinner)
    Spinner spinner;
    private String date, nameTeam, idField;
    private ArrayList<Match> list = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_request);
        ButterKnife.bind(this);

        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        String title = getIntent().getStringExtra("Title");
        mTitle.setText(title);

        SharedPreferences sharedPreferences = getSharedPreferences(SHARED_PREFS, Context.MODE_PRIVATE);
        String id = sharedPreferences.getString(ID, "");

        getField();

        btnReq.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                nameTeam = edtNameTeam.getText().toString().trim();
                System.out.println("Send data : " + date + " " + id + " " + nameTeam + " " + idField);
                AndroidNetworking.post(Constants.BASE_URL + "/api/match")
                        .addBodyParameter("date", date)
                        .addBodyParameter("user_id", id)
                        .addBodyParameter("field_id", idField)
                        .addBodyParameter("teamReq", nameTeam)
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONObject(new JSONObjectRequestListener() {
                            @Override
                            public void onResponse(JSONObject response) {
                                // do anything with response
                                System.out.println("Respone : " + response);
                                Intent intent = new Intent(RequestActivity.this, MyMatchActivity.class);
                                startActivity(intent);
                            }

                            @Override
                            public void onError(ANError error) {
                                Toast.makeText(RequestActivity.this, Constants.TOAST_AN_ERROR, Toast.LENGTH_SHORT).show();
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

    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        Match field = (Match) parent.getSelectedItem();
        String name = field.getName();
        idField = field.getIdField();
    }

    @Override
    public void onNothingSelected(AdapterView<?> parent) {

    }

    public void getDate(View view) {
        DialogFragment datePicker = new DatePickerFragment();
        datePicker.show(getSupportFragmentManager(), "date picker");
    }

    @Override
    public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
        date = year + "-" + (month + 1) + "-" + dayOfMonth;
        edtDate.setText(date);
    }

    public void getField() {
        AndroidNetworking.get(Constants.BASE_URL + "/api/fieldAll")
                .setPriority(Priority.LOW)
                .build()
                .getAsJSONObject(new JSONObjectRequestListener() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray data = response.getJSONArray("data");
                            for (int i = 0; i < data.length(); i++) {
                                JSONObject item = data.getJSONObject(i);
                                Match field = new Match();
                                field.setIdField(item.getString("id"));
                                field.setName(item.getString("name"));
                                list.add(field);
                            }
                            showSpinner();
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }

                    @Override
                    public void onError(ANError error) {
                        Toast.makeText(RequestActivity.this, Constants.TOAST_AN_ERROR, Toast.LENGTH_SHORT).show();
                        Log.d("SCA", "onErrorBody: " + error.getErrorBody());
                        Log.d("SCA", "onErrorLocalMessage: " + error.getLocalizedMessage());
                        Log.d("SCA", "onErrorResponse: " + error.getResponse());
                        Log.d("SCA", "onErrorCode: " + error.getErrorCode());
                        Log.d("SCA", "onErrorDetail: " + error.getErrorDetail());
                    }
                });
    }

    public void showSpinner() {
        ArrayAdapter<Match> adapter = new ArrayAdapter<>(this,
                android.R.layout.simple_spinner_item, list);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);
        spinner.setOnItemSelectedListener(this);
    }

    public boolean onSupportNavigateUp() {
        finish();
        return true;
    }
}
