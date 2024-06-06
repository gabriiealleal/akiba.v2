const TituloDaMateriaLoading = () => {
    return (
        <div className="mb-6">
            <label htmlFor="titulo" className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Título</label>
            <input type="text" id="titulo" name="titulo" className="w-full h-10 rounded-md p-2 outline-none font-averta bg-gray-700 rounded-md animate-pulse"/>
        </div>
    )
}
export default TituloDaMateriaLoading;