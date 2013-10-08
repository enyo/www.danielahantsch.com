function Menu (pics)
{


	this.pics = pics;

	this.active_pic = false;

	this.mouse_over = function (this_pic)
		{
			if (this.active_pic != this_pic)
			{
				document.getElementById ('img_' + this_pic).src = 'pics/menu/active.' + this_pic + '.gif';
			}
		}


	this.mouse_out = function (this_pic)
		{
			if (this.active_pic != this_pic)
			{
				document.getElementById ('img_' + this_pic).src = 'pics/menu/' + this_pic + '.gif';
			}
		}

	this.set_active = function (this_pic)
		{
			if (this_pic != 'default' && this.active_pic != this_pic)
			{
				this.mouse_over (this_pic);
	
				if (this.active_pic != false)
				{
					this.unset_active (this.active_pic);
				}
				this.active_pic = this_pic;
			}
		}

	this.unset_active = function (this_pic)
		{
			this.active_pic = false;
			this.mouse_out (this_pic);
		}

	this.preload_images = function ()
		{
			var image_obj = new Image ();

			for (i = 0; i < this.pics.length; i++)
			{
				image_obj.src = 'pics/menu/active.' + this.pics[i] + '.gif';
			}
		}

	this.preload_images ();

}