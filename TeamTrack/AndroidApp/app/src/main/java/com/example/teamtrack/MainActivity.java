package com.example.teamtrack;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity implements View.OnClickListener {

    private EditText editTextName,editTextEmail,editTextPassword;
    private Button buttonRegister;
    private ProgressDialog progressDialog;

    private TextView textViewLogin;


    //checks if logged and button definitions
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if(SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            startActivity(new Intent(this, ProfileActivity.class));
            return;
        }
        editTextName = (EditText) findViewById(R.id.editTextName);
        editTextEmail = (EditText) findViewById(R.id.editTextEmail);
        editTextPassword = (EditText) findViewById(R.id.editTextPassword);
        textViewLogin = (TextView) findViewById(R.id.textViewLogin);
        buttonRegister = (Button) findViewById(R.id.buttonRegister);

        progressDialog = new ProgressDialog(this);


        buttonRegister.setOnClickListener(this);
        textViewLogin.setOnClickListener(this);
    }

    //takes in textfield inputs and push them to the database
    private void registerUser(){


        final String name = editTextName.getText().toString().trim();
        final String email = editTextEmail.getText().toString().trim();
        final String password = editTextPassword.getText().toString().trim();

        progressDialog.setMessage("Registering User");
        progressDialog.show();
        StringRequest stringRequest= new StringRequest(Request.Method.POST, Constants.URL_REGISTER,
            new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                progressDialog.dismiss();

                try {
                    JSONObject jsonObject= new JSONObject(response);
                    Toast.makeText(getApplicationContext(),jsonObject.getString("message"),Toast.LENGTH_LONG).show();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressDialog.hide();
                Toast.makeText(getApplicationContext(),error.getMessage(),Toast.LENGTH_LONG).show();
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> params =new HashMap<>();
                params.put("name",name);
                params.put("email",email);
                params.put("password",password);
                return params;
            }
        };


        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
    }


    //register clicks
    @Override
    public void onClick(View view) {
        if (view == buttonRegister)
            registerUser();
        if(view == textViewLogin)
            startActivity(new Intent(this, LoginActivity.class));


    }
}
