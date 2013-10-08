function get_XMLHttpRequest_object ()
{
	var tmp_xmlhttp;
	
	try
	{
		tmp_xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e)
	{
		try
		{
			tmp_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (E)
		{
			tmp_xmlhttp = false;
		}
	}
	
	if (!tmp_xmlhttp && typeof XMLHttpRequest!='undefined')
	{
		tmp_xmlhttp = new XMLHttpRequest();
	}
	
	
	return tmp_xmlhttp;

}



function Gallery ()
{

	this.selected_gallery = -1;
	this.selected_picture = -1;

	this.galleries = new Array ();
	this.gallery_pictures = new Array ();

	this.picture_infos = new Array ();

	this.set_galleries = function (galleries)
	{
		this.galleries = galleries;
		
		var galleries_container = document.getElementById ('galleries');
		
		galleries_container.innerHTML = '';
		for (var i = 0; i < this.galleries.length; i ++)
		{
			galleries_container.innerHTML += '<a id="gallery_link_' + i + '" href="javascript: Gallery.select_gallery (' + i + ');">' + this.galleries[i] + '</a><br />';
		}
	
	}




	this.set_pictures = function (gallery_id, pictures)
	{
	
		this.gallery_pictures[gallery_id] = pictures;
	
	}



	this.select_gallery = function (gallery_id)
	{
		this.highlight_gallery (gallery_id);
		this.selected_gallery = gallery_id;
		this.selected_picture = -1;

		document.getElementById ('picture').style.display = 'none';
		document.getElementById ('navigation').style.display = 'none';

		var thumbnail_container = document.getElementById ('thumbnails');
		
		thumbnail_container.innerHTML = '';
		thumbnail_container.style.display = 'block';

		for (var i = 0; i < this.gallery_pictures[gallery_id].length; i ++)
		{
			thumbnail_container.innerHTML += '<a href="javascript: Gallery.show_picture (' + gallery_id + ', ' + i + ');" title="click to enlarge"><img class="thumbnail" src="galleries/' + this.galleries[gallery_id] + '/thumbs/thumb.' + this.gallery_pictures[gallery_id][i] + '.png" width="120" height="75" alt="click to enlarge" /></a>';
		}

	}

	this.highlight_gallery = function (gallery_id)
	{
		if (this.selected_gallery != -1)
		{
			document.getElementById ('gallery_link_' + this.selected_gallery).className = 'inactive';
		}
		document.getElementById ('gallery_link_' + gallery_id).className = 'active';
	}

	this.show_picture = function (gallery_id, picture_id)
	{
		this.highlight_gallery (gallery_id);
		this.selected_gallery = gallery_id;
		this.selected_picture = picture_id;

		this.set_picture_ids ();

		document.getElementById ('thumbnails').style.display = 'none';
		document.getElementById ('navigation').style.display = 'block';

		var picture_container = document.getElementById ('picture');

		picture_container.innerHTML = '';
		picture_container.style.display = 'block';

		picture_container.innerHTML = '<img class="picture" src="galleries/' + this.galleries[gallery_id] + '/' + this.gallery_pictures[gallery_id][picture_id] + '" alt="image" /><div id="picture_text">Loading ...</div>';
		if (typeof (this.picture_infos[this.gallery_pictures[gallery_id][picture_id]]) != 'object' || true)
		{
			var load_infos_xmlhttp = get_XMLHttpRequest_object ();
	
			load_infos_xmlhttp.open("GET", 'http://www.danielahantsch.com/get_picture_infos.php?picture_name=' + this.gallery_pictures[gallery_id][picture_id]);

			load_infos_xmlhttp.onreadystatechange = function ()
			{
				if (load_infos_xmlhttp.readyState == 4 && load_infos_xmlhttp.status == 200)
				{
					var eval_command = load_infos_xmlhttp.responseText;

					eval (eval_command);
					Gallery.picture_infos[Gallery.gallery_pictures[gallery_id][picture_id]] = picture_infos;

					Gallery.set_picture_text (gallery_id, picture_id);
				}
			}
			load_infos_xmlhttp.send(null);
		}
		else
		{
			this.set_picture_text (gallery_id, picture_id);
		}
	}


	this.set_picture_text = function (gallery_id, picture_id)
	{
		var picture_infos = this.picture_infos[this.gallery_pictures[gallery_id][picture_id]];
		
		if (this.selected_gallery == gallery_id && this.selected_picture == picture_id)
		{
			var picture_text = document.getElementById ('picture_text');

			if (picture_text)
			{
				picture_text.innerHTML = '<h1>' + picture_infos['title'] + '</h1>';
				picture_text.innerHTML += '<div id="picture_year">' + picture_infos['year'] + '</div>';
				picture_text.innerHTML += picture_infos['material'];
				picture_text.innerHTML += ', ' + picture_infos['size'];
				picture_text.innerHTML += '<br />' + picture_infos['price'] + ' &euro;';
			}
		}
	}



	this.set_picture_ids = function ()
	{
		var pic_ids_container = document.getElementById ('pic_ids');
		pic_ids_container.innerHTML = '';
		for (var i = 0; i < this.gallery_pictures[this.selected_gallery].length; i ++)
		{
			if (i == this.selected_picture) { pic_ids_container.innerHTML += ' <span style="color: #aa0000; font-weight: bold;">' + (i + 1) + '</span> / '; }
			else                            { pic_ids_container.innerHTML += ' <a href="javascript: Gallery.show_picture (' + this.selected_gallery + ', ' + i + ')">' + (i + 1) + '</a> / '; }
		
		}
	}

	this.next_picture = function ()
	{
		if (this.selected_picture >= this.gallery_pictures[this.selected_gallery].length - 1) { this.select_gallery (this.selected_gallery); }
		else
		{
			this.show_picture (this.selected_gallery, this.selected_picture + 1);
		}
	}


	this.previous_picture = function ()
	{
		if (this.selected_picture <= 0) { this.select_gallery (this.selected_gallery); }
		else
		{
			this.show_picture (this.selected_gallery, this.selected_picture - 1);
		}
	}
}

var Gallery = new Gallery ();