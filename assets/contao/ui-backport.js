window.onload = () => {

	const updateLightModeRowIcon = (el, published) =>
	{
		let img = null

		const div = el.closest('div')

		if (div.classList.contains('tl_right'))
			img = div.previousElementSibling.querySelectorAll('img')

		else if (div.classList.contains('tl_listing_container'))
			img = el.closest('td').previousElementSibling.querySelector('div.list_icon')
			   || el.closest('td').previousElementSibling.querySelector('div.cte_type')
			   || el.closest('tr').querySelector('td div.list_icon_new')

		else if (div.nextElementSibling)
			img = div.nextElementSibling.classList.contains('cte_type')
				? div.nextElementSibling
				: div.nextElementSibling.querySelector('div.list_icon')

		if (img !== null)
		{
			let lightModeIcon = img instanceof NodeList
										? img[1]
										: null

			if (null === lightModeIcon)
			{
				return
			}

			// Tree view
			if ('img' === lightModeIcon.nodeName.toLowerCase())
			{
				const parentUl = lightModeIcon.closest('ul.tl_listing')

				if (!parentUl.classList.contains('tl_tree_xtnd'))
				{
					const pa = lightModeIcon.closest('a')

					if (pa && !pa.href.includes('contao/preview'))
					{
						const next = pa.nextElementSibling
						lightModeIcon = next
									  ? next.querySelector('img')
									  : document.createElement('img') // no icons used (see #2286)
					}
				}

				const newSrc = !published
									 ? lightModeIcon.dataset.icon
									 : lightModeIcon.dataset.iconDisabled

				lightModeIcon.src = (lightModeIcon.src.includes('/') && !newSrc.includes('/'))
								  ? lightModeIcon.src.slice(0, lightModeIcon.src.lastIndexOf('/') + 1) + newSrc
								  : newSrc
			}

			// Parent view
			else if (lightModeIcon.classList.contains('cte_type'))
			{
				lightModeIcon.classList.toggle('published', !published)
				lightModeIcon.classList.toggle('unpublished', published)
			}

			// List view
			else
				lightModeIcon.style.backgroundImage = `url(${!published ? lightModeIcon.dataset.icon : lightModeIcon.dataset.iconDisabled})`

		}
	}

	const updateStateAndIcon = (el, published) => {

		if (el.dataset.state && el.dataset.state !== published ? '0' : '1')
		{
			el.dataset.state = published ? '0' : '1'
		}

		el.src = published ? el.dataset?.iconDisabled : el.dataset?.icon
	}

	const toggleBackendIcon = (e) => {
		const published = e.currentTarget.dataset?.state === '1'

		const darkIcon = e.currentTarget
		const lightIcon = e.currentTarget.nextSibling

		if (lightIcon)
			updateStateAndIcon(lightIcon, published)
		else
			updateStateAndIcon(darkIcon, published)

		updateLightModeRowIcon(e.currentTarget, published)
	}

	const toggleIcons = document.querySelectorAll('a > img[data-icon][data-icon-disabled]')

	toggleIcons?.forEach(img => {
		img.addEventListener('click', toggleBackendIcon)
	})
}
