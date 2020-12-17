<template>
	<div class="container h-100 login">
		<div class="row justify-content-center align-items-center h-100">
			<div class="col-sm-6 col-md-6 col-lg-6">
				<el-card class="box-card" v-loading="loading" element-loading-text="Logging in...">
					<div class="row">
						<div class="col-md-12">
							<h3 class="text-center font-weight-bold">Welcome Back!</h3>

			            	<div class="mt-4">
			            		<el-form
			            			@keyup.enter.native.prevent="login"
			            			ref="loginForm"
			            			:model="loginForm"
			            			:rules="rules"
			            			class="critical-path-el-form">
			            			<el-form-item
			            				label="Username"
			            				prop="username"
			            				class="el-form-item-spacing">
			                			<el-input
			                				class="round-input"
			                				v-model="loginForm.username" 
			                				clearable
			                				placeholder="Enter username">
			                			</el-input>
			                		</el-form-item>
			                		<el-form-item
			                			label="Password"
			                			prop="password"
			                			:error="hasError('password', true)">     
			                			<el-input
			                				class="round-input		"
			                				v-model="loginForm.password"
			                				type="password"
			                				placeholder="Enter password"
			                				show-password>
			                			</el-input>
			                		</el-form-item>

			                		<el-form-item
			                			prop="remember">
			                			<el-checkbox v-model="loginForm.remember">Remember me</el-checkbox>
			                		</el-form-item>

			                		<el-button
			                			round
			                			type="primary"
			                			class="full-width mt-2"
			                			@click="login">
			                			Login
			                		</el-button>  
			            		</el-form>
			            	</div>
						</div>
					</div>
            	</el-card>
			</div>
		</div>
	</div>        
</template>

<script>
	import { formHelper } from '../mixins/formHelper'
	export default {
		name: 'Login',
		mixins: [formHelper],
		data() {
			return {
				loginForm: {
					username: null,
					password: null,
					remember: false
				},
				rules: {
					username: [
						{
							required: true,
							type: 'string',
							trigger: 'blur',
							message: 'Username field is required'
						}
					],
					password: {
						required: true,
						type: 'string',
						trigger: 'blur',
						message: 'Password field is required.'
					}
				},
				loading: false
			}
		},
		methods: {
			login() {
				this.$refs.loginForm.validate(valid => {
					if (valid) { 
						this.resetErrors() // check formError mixin
						this.loading = true
						this.$API.User.login(this.loginForm)
						.then(res => { 
							if (!res.data.success) {
								let error = ['Invalid username or password.']

								this.form.errors = {
									password: error
								} 

								return
							}

							window.location.href = res.data.url
						}) 
						.catch(err => {
							console.log(err)
						})
						.finally(_ => {
							this.loading = false
						})
					}
				})
			} 
		}
	}
</script>

<style lang="scss">
	.login {
		.side-info {
			display: flex;
			justify-content: center;
			align-items: center;
			text-align: center;
		}

		@media (max-width: 768px) { 
			.side-info {
				margin-top: 50px;
			}
		}
	}
</style>