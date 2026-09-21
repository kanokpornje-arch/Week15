const fs = require('node:fs');
const credentials = {email: '{{email}}', password: '{{password}}'};
const registration = {name: 'Worksheet 15', ...credentials, password_confirmation: '{{password}}'};
const cases = [
 ['Register','POST','/register',201,registration,false,'register_token'],
 ['Duplicate registration','POST','/register',422,registration],
 ['Invalid registration','POST','/register',422,{}],
 ['Wrong password','POST','/login',401,{...credentials,password:'incorrect'}],
 ['Invalid login','POST','/login',422,{}],
 ['Login','POST','/login',200,credentials,false,'token'],
 ['User without token','GET','/user',401],
 ['User with token','GET','/user',200,null,true],
 ['Public list','GET','/blogs',200],
 ['Create without token','POST','/blogs',401,{title:'Test',content:'Test'}],
 ['Invalid blog','POST','/blogs',422,{},true],
 ['Create blog','POST','/blogs',201,{title:'Worksheet 15',content:'API test content'},true,'blog_id'],
 ['Public detail','GET','/blogs/{{blog_id}}',200],
 ['Update without token','PUT','/blogs/{{blog_id}}',401,{title:'Denied'}],
 ['Invalid update','PUT','/blogs/{{blog_id}}',422,{title:''},true],
 ['Update blog','PUT','/blogs/{{blog_id}}',200,{title:'Updated worksheet',content:'Updated content'},true],
 ['Delete without token','DELETE','/blogs/{{blog_id}}',401],
 ['Delete blog','DELETE','/blogs/{{blog_id}}',200,null,true],
 ['Missing blog','GET','/blogs/{{blog_id}}',404],
 ['Logout without token','POST','/logout',401],
 ['Logout','POST','/logout',200,null,true],
 ['Revoked token','GET','/user',401,null,true],
 ['Revoke registration token','POST','/logout',200,null,'register_token'],
];
const item = cases.map(([name,method,path,status,body,auth,save],i) => {
 const exec = [`pm.test('HTTP ${status}', () => pm.response.to.have.status(${status}));`, `pm.test('JSON response', () => pm.expect(pm.response.headers.get('Content-Type')).to.include('application/json'));`];
 if(save) exec.push(`pm.collectionVariables.set('${save}', pm.response.json().${save==='blog_id'?'data.id':'token'});`);
 const event = [{listen:'test',script:{type:'text/javascript',exec}}];
 if(i===0) event.unshift({listen:'prerequest',script:{type:'text/javascript',exec:[`pm.collectionVariables.set('email', 'worksheet15-' + Date.now() + '@example.com');`]}});
 const request = {method,header:[{key:'Accept',value:'application/json'},{key:'Content-Type',value:'application/json'}],auth:auth?{type:'bearer',bearer:[{key:'token',value:'{{'+(auth===true?'token':auth)+'}}',type:'string'}]}:{type:'noauth'},url:'{{base_url}}'+path};
 if(body) request.body = {mode:'raw',raw:JSON.stringify(body,null,2),options:{raw:{language:'json'}}};
 return {name:`${i+1}. ${name}`,event,request};
});
const variable = Object.entries({base_url:'http://127.0.0.1:8000/api',email:'',password:'Worksheet15-Test!',token:'',register_token:'',blog_id:''}).map(([key,value])=>({key,value}));
fs.writeFileSync(__dirname+'/Week15.postman_collection.json',JSON.stringify({info:{name:'Week15 RESTful Blog API',schema:'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'},variable,item},null,2));
