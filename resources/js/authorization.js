const user = window.App.user;
export default {

	owns(model)
	{
		if(!user) return false

		return user.id === model.user_id
	},

	isLoggedIn() 
	{
		return !!user
	},

	isAdmin()
	{	
		if (!user) return false

		return user.isAdmin
	}

};