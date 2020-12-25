async function getData(url,data)
{
	
	let res = await fetch(url,{
		method: data.method || 'GET',
		body: data.json || {}
	});

	let result = await res.json;

}