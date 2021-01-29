package com.example.sportsclub.activities;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

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
import static com.example.sportsclub.activities.SignInActivity.TOKEN;
import static com.example.sportsclub.activities.SignInActivity.USERNAME;

public class SignUpActivity extends AppCompatActivity implements View.OnClickListener {
    @BindView(R.id.progressBar)
    ProgressBar progressBar;
    @BindView(R.id.btn_sign_up)
    Button btnSignUp;
    @BindView(R.id.edt_username)
    EditText edtUsername;
    @BindView(R.id.edt_name)
    EditText edtName;
    @BindView(R.id.edt_address)
    EditText edtAddress;
    @BindView(R.id.edt_phone_number)
    EditText edtPhoneNumber;
    @BindView(R.id.edt_email)
    EditText edtEmail;
    @BindView(R.id.edt_password)
    EditText edtPassword;
    @BindView(R.id.edt_confirm_password)
    EditText edtConfirmPassword;
    private String token;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);
        ButterKnife.bind(this);

        btnSignUp.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        if (v.getId() == R.id.btn_sign_up) {
            SharedPreferences sharedPreferences = getSharedPreferences(SHARED_PREFS, MODE_PRIVATE);
            token = sharedPreferences.getString(TOKEN, "");

            String inputUsername = edtUsername.getText().toString().trim();
            String inputName = edtName.getText().toString().trim();
            String inputAddress = edtAddress.getText().toString().trim();
            String inputPhoneNumber = edtPhoneNumber.getText().toString().trim();
            String inputEmail = edtEmail.getText().toString().trim();
            String inputPassword = edtPassword.getText().toString().trim();
            String inputConfirmPassword = edtConfirmPassword.getText().toString().trim();

            boolean isEmpty = false;
            boolean isInvalidPassword = false;

            if (inputUsername.isEmpty()) {
                isEmpty = true;
                edtUsername.setError("Username harus diisi");
            }

            if (inputName.isEmpty()) {
                isEmpty = true;
                edtName.setError("Name harus diisi");
            }

            if (inputAddress.isEmpty()) {
                isEmpty = true;
                edtAddress.setError("Address harus diisi");
            }

            if (inputPhoneNumber.isEmpty()) {
                isEmpty = true;
                edtPhoneNumber.setError("Phone Number harus diisi");
            }

            if (inputEmail.isEmpty()) {
                isEmpty = true;
                edtEmail.setError("Email harus diisi");
            }

            if (inputPassword.isEmpty()) {
                isEmpty = true;
                edtPassword.setError("Password harus diisi");
            }

            if (inputConfirmPassword.isEmpty()) {
                isEmpty = true;
                edtConfirmPassword.setError("Confirm Password harus diisi");
            }

            if (!inputPassword.equals(inputConfirmPassword)) {
                isInvalidPassword = true;
                edtConfirmPassword.setError("Password & Confirm Password don't match");
            }

            if (!isEmpty && !isInvalidPassword) {
                btnSignUp.setVisibility(View.GONE);
                progressBar.setVisibility(View.VISIBLE);
                AndroidNetworking.post(Constants.BASE_URL + "/api/register")
                        .addBodyParameter("username", inputUsername)
                        .addBodyParameter("name", inputName)
                        .addBodyParameter("address", inputAddress)
                        .addBodyParameter("phone", inputPhoneNumber)
                        .addBodyParameter("email", inputEmail)
                        .addBodyParameter("password", inputPassword)
                        .addBodyParameter("token", token)
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONObject(new JSONObjectRequestListener() {
                            @Override
                            public void onResponse(JSONObject response) {
                                try {
                                    String status = response.getString("status");
                                    String message = response.getString("message");
                                    if (status.equals("success")) {
                                        JSONObject data = response.getJSONObject("data");
                                        String name = data.getString("name");
                                        String id = data.getString("id");
                                        String email = data.getString("email");
                                        String username = data.getString("username");
                                        String phoneNumber = data.getString("phone");
                                        String address = data.getString("address");
                                        System.out.println("data : " + data);
                                        System.out.println("name : " + name);

                                        SharedPreferences sharedPreferences = getSharedPreferences(SHARED_PREFS, MODE_PRIVATE);
                                        SharedPreferences.Editor editor = sharedPreferences.edit();

                                        editor.putString(ID, id);
                                        editor.putString(NAME, name);
                                        editor.putString(EMAIL, email);
                                        editor.putString(USERNAME, username);
                                        editor.putString(PHONE, phoneNumber);
                                        editor.putString(ADDRESS, address);
                                        editor.apply();

                                        Intent intent = new Intent(SignUpActivity.this, MainDashboardActivity.class);
                                        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                        startActivity(intent);

                                        Toast.makeText(SignUpActivity.this, "Selamat datang " + name, Toast.LENGTH_SHORT).show();
                                        finish();
                                    } else {
                                        Toast.makeText(SignUpActivity.this, message, Toast.LENGTH_SHORT).show();
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            }

                            @Override
                            public void onError(ANError error) {
                                Toast.makeText(SignUpActivity.this, Constants.TOAST_AN_ERROR, Toast.LENGTH_SHORT).show();
                                Log.d("SCA", "onErrorBody: " + error.getErrorBody());
                                Log.d("SCA", "onErrorLocalMessage: " + error.getLocalizedMessage());
                                Log.d("SCA", "onErrorResponse: " + error.getResponse());
                                Log.d("SCA", "onErrorCode: " + error.getErrorCode());
                                Log.d("SCA", "onErrorDetail: " + error.getErrorDetail());
                                progressBar.setVisibility(View.GONE);
                                btnSignUp.setVisibility(View.VISIBLE);
                            }
                        });
            }
        }
    }
}
