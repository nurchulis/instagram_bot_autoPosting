from instabot import Bot


bot = Bot(
	filter_users=False,
    filter_private_users=False,
    filter_previously_followed=False,
    filter_business_accounts=False,
    filter_verified_accounts=False
    )
bot.login(username="nurchuliss", password="lina@maulana")
##user_id = bot.get_user_id_from_username("lego")
##user_info = bot.get_user_info(user_id)
bot.upload_photo("photo/02.jpg", caption="Nice")
#hastag=bot.get_hashtag_medias("corona")
#bot.like_user("menabungtanah")


